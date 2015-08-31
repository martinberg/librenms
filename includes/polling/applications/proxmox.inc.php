<?php

if (isset($config['enable_proxmox']) && $config['enable_proxmox'] && !empty($agent_data['app']['proxmox'])) {
    $proxmox = $agent_data['app']['proxmox'];
}

function proxmox_port_exists($i, $c, $p) {
    if ($row = dbFetchRow("SELECT pmp.id FROM proxmox_ports pmp, proxmox pm WHERE pm.id = pmp.vm_id AND pmp.port = ? AND pm.cluster = ? AND pm.vmid = ?", array($p, $c, $i))) {
        return $row['id'];
    }

    return false;
}

function proxmox_vm_exists($i, $c, &$pmxcache) {

    if (isset($pmxcache[$c][$i]) && $pmxcache[$c][$i] > 0) {
        return true;
    }
    if ($row = dbFetchRow("SELECT id FROM proxmox WHERE vmid = ? AND cluster = ?", array($i, $c))) {
        $pmxcache[$c][$i] = (integer) $row['id'];
        return true;
    }

    return false;
}

$pmxlines = explode("\n", $proxmox);

if (count($pmxlines) > 2) {
    $pmxcluster = array_shift($pmxlines);

    $pmxcdir = join('/', array($config['rrd_dir'],'proxmox',$pmxcluster));
    if (!is_dir($pmxcdir)) {
        mkdir($pmxcdir, 0775, true);
    }

    dbUpdate(array('device_id' => $device['device_id'], 'app_type' => 'proxmox', 'app_instance' => $pmxcluster), 'applications', '`device_id` = ? AND `app_type` = ?', array($device['device_id'], 'proxmox'));

    $pmxcache = [];

    foreach ($pmxlines as $vm) {
        list($vmid, $vmport, $vmpin, $vmpout, $vmdesc) = explode('/', $vm, 5);

        $rrd_filename = join('/', array(
            $pmxcdir,
            $vmid.'_netif_'.$vmport.'.rrd'));

        if (!is_file($rrd_filename)) {
            rrdtool_create(
                $rrd_filename,
                ' --step 300 \
                DS:INOCTETS:DERIVE:600:0:12500000000 \
                DS:OUTOCTETS:DERIVE:600:0:12500000000 '.$config['rrd_rra']);
        }

        rrdtool_update($rrd_filename, 'N:'.$vmpin.':'.$vmpout);
        if (proxmox_vm_exists($vmid, $pmxcluster, $pmxcache) === true) {
            dbUpdate(array('device_id' => $device['device_id'], 'last_seen' => array('NOW()'), 'description' => $vmdesc), 'proxmox', '`vmid` = ? AND `cluster` = ?', array($vmid, $pmxcluster));
        }
        else {
            $pmxcache[$pmxcluster][$vmid] = dbInsert(array('cluster' => $pmxcluster, 'vmid' => $vmid, 'description' => $vmdesc, 'device_id' => $device['device_id']), 'proxmox');
        }

        if ($portid = proxmox_port_exists($vmid, $pmxcluster, $vmport) !== false) {
            dbUpdate(array('last_seen' => array('NOW()')), 'proxmox_ports', '`vm_id` = ? AND `port` = ?', array($pmxcache[$pmxcluster][$vmid], $vmport));
        }
        else {
            dbInsert(array('vm_id' => $pmxcache[$pmxcluster][$vmid], 'port' => $vmport), 'proxmox_ports');
        }

    }

    unset($pmxlines);
    unset($pmxcluster);
    unset($pmxcdir);
    unset($proxmox);
    unset($pmxcache);
}
