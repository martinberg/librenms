#!/usr/bin/env php
<?php

use LibreNMS\Config;
use LibreNMS\Proc;
use LibreNMS\Util\ModuleTestHelper;
use LibreNMS\Util\Snmpsim;

global $device;

$install_dir = realpath(__DIR__ . '/..');
chdir($install_dir);

$options = getopt(
    'o:v:m:nf:dh',
    array(
        'os:',
        'variant:',
        'modules:',
        'no-save',
        'file:',
        'debug',
        'snmpsim',
        'help',
    )
);

$init_modules = array('discovery', 'polling');
require $install_dir . '/includes/init.php';

$debug = (isset($options['d']) || isset($options['debug']));
$vdebug = $debug;


if (isset($options['snmpsim'])) {
    $snmpsim = new Snmpsim();
    $snmpsim->run();
    exit;
}


if (isset($options['h'])
    || isset($options['help'])
    || !(isset($options['o']) || isset($options['os']) || isset($options['m']) || isset($options['modules']))
) {
    echo "Script to update test data. Database data is saved in tests/data.

Usage:
  You must specify a valid OS and/or module(s).

  -o, --os           Name of the OS to save test data for
  -v, --variant      The variant of the OS to use, usually the device model
  -m, --modules      The discovery/poller module(s) to collect data for, comma delimited
  -n, --no-save      Don't save database entries, print them out instead
  -f, --file         Save data to file instead of the standard location
  -d, --debug        Enable debug output
      --snmpsim      Run snmpsimd.py using the collected data for manual testing.
";
    exit;
}

$os_name = false;
if (isset($options['o'])) {
    $os_name = $options['o'];
} elseif (isset($os_list['os'])) {
    $os_name = $options['os'];
}

if (isset($options['m'])) {
    $modules_input = $options['m'];
    $modules = explode(',', $modules_input);
} elseif (isset($options['modules'])) {
    $modules_input = $options['modules'];
    $modules = explode(',', $modules_input);
} else {
    $modules_input = 'all';
    $modules = array();
}

$full_os_name = $os_name;
$variant = '';
if (isset($options['v'])) {
    $variant = $options['v'];
    $full_os_name = $os_name . '_' . $variant;
} elseif (isset($options['variant'])) {
    $variant = $options['variant'];
    $full_os_name = $os_name . '_' . $variant;
}

$os_list = array();

if ($os_name) {
    $os_list = [$full_os_name => [$os_name, $variant]];
} else {
    $os_list = ModuleTestHelper::findOsWithData($modules);
}


// Now use the saved data to update the saved database data
$snmpsim = new Snmpsim();
$snmpsim->fork();
$snmpsim_ip = $snmpsim->getIp();
$snmpsim_port = $snmpsim->getPort();

if (!$snmpsim->isRunning()) {
    echo "Failed to start snmpsim, make sure it is installed, working, and there are no bad snmprec files.\n";
    exit;
}


$no_save = isset($options['n']) || isset($options['no-save']);
foreach ($os_list as $full_os_name => $parts) {
    list($target_os, $target_variant) = $parts;
    echo "OS: $target_os\n";
    echo "Module: $modules_input\n";
    if ($target_variant) {
        echo "Variant: $target_variant\n";
    }
    echo PHP_EOL;

    $tester = new ModuleTestHelper($modules, $target_os, $target_variant);

    $test_data = $tester->generateTestData($snmpsim, $no_save);

    if ($no_save) {
        print_r($test_data);
    }
}
