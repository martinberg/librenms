<?php

if (!$os) {
    if (strstr($sysObjectId, '.1.3.6.1.4.1.1411.102')) {
        $os = 'juniperex2500os';
    }
}
