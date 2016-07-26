<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Søren Friis Rosiak <sorenrosiak@gmail.com> 
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'comware') {
    
    $entphydata = dbFetchRows("SELECT `entPhysicalIndex`, `entPhysicalClass`, `entPhysicalName` FROM `entPhysical` WHERE `device_id` = ? AND `entPhysicalClass` REGEXP 'module|sensor' ORDER BY `entPhysicalIndex`", array(
        $device['device_id']
    ));
    
    if (!empty($entphydata)) {

        $tempdata   = snmpwalk_cache_multi_oid($device, 'hh3cEntityExtTemperature', array(), 'HH3C-ENTITY-EXT-MIB');

        foreach ($entphydata as $index) {
            foreach ($tempdata as $tempindex => $value) {
                if ($index['entPhysicalIndex'] == $tempindex) {
                    $cur_oid = '.1.3.6.1.4.1.25506.2.6.1.1.1.1.12.';
                    discover_sensor($valid['sensor'], 'temperature', $device, $cur_oid . $tempindex, $tempindex, 'comware', $index['entPhysicalDescr'], '1', '1', null, null, null, null, $value['hh3cEntityExtTemperature'], 'snmp', $index);
                }
            }
            
        }
    }
}
