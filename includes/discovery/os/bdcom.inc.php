<?php

if (!$os) {
    if (strstr($sysObjectId, '.1.3.6.1.4.1.3320.1.185')) {
        $os = 'bdcom';
    }
}
