<?php

global $debug;

if ($device['os_group'] == 'unix') {
    echo $config['project_name'].' UNIX Agent: ';

    // FIXME - this should be in config and overridable in database
    $agent_port = '6556';

    $agent_start = utime();
    $agent       = fsockopen($device['hostname'], $agent_port, $errno, $errstr, $config['unix-agent-connection-time-out']);

    // Set stream timeout (for timeouts during agent  fetch
    stream_set_timeout($agent, $config['unix-agent-read-time-out']);
    $agentinfo = stream_get_meta_data($agent);

    if (!$agent) {
        echo 'Connection to UNIX agent failed on port '.$port.'.';
    }
    else {
        // fetch data while not eof and not timed-out
        while ((!feof($agent)) && (!$agentinfo['timed_out'])) {
            $agent_raw .= fgets($agent, 128);
            $agentinfo  = stream_get_meta_data($agent);
        }

        if ($agentinfo['timed_out']) {
            echo 'Connection to UNIX agent timed out during fetch on port '.$port.'.';
        }
    }

    $agent_end  = utime();
    $agent_time = round(($agent_end - $agent_start) * 1000);

    if (!empty($agent_raw)) {
        echo 'execution time: '.$agent_time.'ms';
        $agent_rrd = $config['rrd_dir'].'/'.$device['hostname'].'/agent.rrd';
        if (!is_file($agent_rrd)) {
            rrdtool_create($agent_rrd, 'DS:time:GAUGE:600:0:U '.$config['rrd_rra']);
        }

        $fields = array(
            'time' => $agent_time,
        );
 
        rrdtool_update($agent_rrd, $fields);
        $graphs['agent'] = true;

        foreach (explode('<<<', $agent_raw) as $section) {
            list($section, $data) = explode('>>>', $section);
            list($sa, $sb)    = explode('-', $section, 2);

            if ($section == 'apache') {
                $sa = 'app';
                $sb = 'apache';
            }

            if ($section == 'mysql') {
                $sa = 'app';
                $sb = 'mysql';
            }

            if ($section == 'nginx') {
                $sa = 'app';
                $sb = 'nginx';
            }

            if ($section == 'bind') {
                $sa = 'app';
                $sb = 'bind';
            }

            if ($section == 'tinydns') {
                $sa = 'app';
                $sb = 'tinydns';
            }

            // if ($section == "drbd")   { $sa = "app"; $sb = "drbd"; }
            if (!empty($sa) && !empty($sb)) {
                $agent_data[$sa][$sb] = trim($data);
            }
            else {
                $agent_data[$section] = trim($data);
            }
        }//end foreach

        if ($debug) {
            print_r($agent_data);
        }

        include 'unix-agent/packages.inc.php';
        include 'unix-agent/munin-plugins.inc.php';

        foreach (array_keys($agent_data) as $key) {
            if (file_exists("includes/polling/unix-agent/$key.inc.php")) {
                if ($debug) {
                    echo "Including: unix-agent/$key.inc.php";
                }

                include "unix-agent/$key.inc.php";
            }
        }

        foreach (array_keys($agent_data['app']) as $key) {
            if (file_exists("includes/polling/applications/$key.inc.php")) {
                if ($debug) {
                    echo "Including: applications/$key.inc.php";
                }

                include "applications/$key.inc.php";
            }
        }

        // Processes
        if (!empty($agent_data['ps'])) {
            echo 'Processes: ';
            dbDelete('processes', 'device_id = ?', array($device['device_id']));
            $data=array();
            foreach (explode("\n", $agent_data['ps']) as $process) {
                $process = preg_replace('/\((.*),([0-9]*),([0-9]*),([0-9\:]*),([0-9]*)\)\ (.*)/', '\\1|\\2|\\3|\\4|\\5|\\6', $process);
                list($user, $vsz, $rss, $cputime, $pid, $command) = explode('|', $process, 6);
                if (!empty($command)) {
                    $data[]=array('device_id' => $device['device_id'], 'pid' => $pid, 'user' => $user, 'vsz' => $vsz, 'rss' => $rss, 'cputime' => $cputime, 'command' => $command);
                }
            }
            if (count($data) > 0) {
                dbBulkInsert('processes',$data);
            }
            echo "\n";
        }

        // Apache
        if (!empty($agent_data['app']['apache'])) {
            $app_found['apache'] = true;
            if (dbFetchCell('SELECT COUNT(*) FROM `applications` WHERE `device_id` = ? AND `app_type` = ?', array($device['device_id'], 'apache')) == '0') {
                echo "Found new application 'Apache'\n";
                dbInsert(array('device_id' => $device['device_id'], 'app_type' => 'apache'), 'applications');
            }
        }

        // memcached
        if (!empty($agent_data['app']['memcached'])) {
            $agent_data['app']['memcached'] = unserialize($agent_data['app']['memcached']);
            foreach ($agent_data['app']['memcached'] as $memcached_host => $memcached_data) {
                if (dbFetchCell('SELECT COUNT(*) FROM `applications` WHERE `device_id` = ? AND `app_type` = ? AND `app_instance` = ?', array($device['device_id'], 'memcached', $memcached_host)) == '0') {
                    echo "Found new application 'Memcached' $memcached_host\n";
                    dbInsert(array('device_id' => $device['device_id'], 'app_type' => 'memcached', 'app_instance' => $memcached_host), 'applications');
                }
            }
        }

        // MySQL
        if (!empty($agent_data['app']['mysql'])) {
            $app_found['mysql'] = true;
            if (dbFetchCell('SELECT COUNT(*) FROM `applications` WHERE `device_id` = ? AND `app_type` = ?', array($device['device_id'], 'mysql')) == '0') {
                echo "Found new application 'MySQL'\n";
                dbInsert(array('device_id' => $device['device_id'], 'app_type' => 'mysql'), 'applications');
            }
        }

        // DRBD
        if (!empty($agent_data['drbd'])) {
            $agent_data['app']['drbd'] = array();
            foreach (explode("\n", $agent_data['drbd']) as $drbd_entry) {
                list($drbd_dev, $drbd_data) = explode(':', $drbd_entry);
                if (preg_match('/^drbd/', $drbd_dev)) {
                    $agent_data['app']['drbd'][$drbd_dev] = $drbd_data;
                    if (dbFetchCell('SELECT COUNT(*) FROM `applications` WHERE `device_id` = ? AND `app_type` = ? AND `app_instance` = ?', array($device['device_id'], 'drbd', $drbd_dev)) == '0') {
                        echo "Found new application 'DRBd' $drbd_dev\n";
                        dbInsert(array('device_id' => $device['device_id'], 'app_type' => 'drbd', 'app_instance' => $drbd_dev), 'applications');
                    }
                }
            }
        }
    }//end if

    if (!empty($agent_sensors)) {
        echo 'Sensors: ';
        check_valid_sensors($device, 'temperature', $valid['sensor'], 'agent');
        echo "\n";
    }

    echo "\n";
}//end if
