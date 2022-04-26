<?php

$name = 'suricata';
$app_id = $app['app_id'];
$unit_text = 'packets/sec';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 0;
$addarea = 0;
$transparency = 15;

if (isset($vars['instance'])) {
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app['app_id'], $vars['instance']]);
} else {
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app['app_id']]);
}

$rrd_list = [];
if (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Dropped',
        'ds'       => 'dropped',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'IfDropped',
        'ds'       => 'ifdropped',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Errors',
        'ds'       => 'errors',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Dec_Invalid',
        'ds'       => 'dec_invalid',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Too_Many_Layers',
        'ds'       => 'dec_too_many_layer',
    ];
} else {
    d_echo('RRD "' . $rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';
