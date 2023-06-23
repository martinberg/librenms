<?php

$unit_text = 'resp_3xx_other';
$descr = 'resp_3xx_other';
$ds = 'resp_3xx_other';

$filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';
