<?php

if (!$os) {
    if (strstr($sysDescr, 'ZyWALL')) {
        $os = 'zywall';
    }
    if (strstr($sysObjectId, '.1.3.6.1.4.1.890.1.15')) {
        $os = 'zywall';
    }
}
