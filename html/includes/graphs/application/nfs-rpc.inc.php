<?php
require 'includes/graphs/common.inc.php';
$scale_min     = 0;
$colours       = 'mixed';
$unit_text     = 'RPC Stats';
$unitlen       = 15;
$bigdescrlen   = 15;
$smalldescrlen = 15;
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 33;
$rrd_filename  = $config['rrd_dir'].'/'.$device['hostname'].'/app-nfs-stats-'.$app['app_id'].'.rrd';
$array = array(
    'rpc_calls' => array('descr' => 'calls','colour' => '000000',),
    'rpc_badcalls' => array('descr' => 'bad calls','colour' => '600604',),
    'rpc_badfmt' => array('descr' => 'bad fmt','colour' => '8C201D',),
    'rpc_badauth' => array('descr' => 'bad auth','colour' => 'DF7A77',),
    'rpc_badclnt' => array('descr' => 'bad clnt','colour' => 'FFB3B1',),
);

$i = 0;

if (is_file($rrd_filename)) {
    foreach ($array as $ds => $vars) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $vars['descr'];
        $rrd_list[$i]['ds']       = $ds;
        $rrd_list[$i]['colour']   = $vars['colour'];
        $i++;
    }
}
else {
    echo "file missing: $rrd_filename";
}

require 'includes/graphs/generic_multi_line_exact_numbers.inc.php';
