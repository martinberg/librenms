<?php

if (str_contains($sysDescr, 'Comware')) {
    $os = 'comware';
} elseif (preg_match('/HP [a-zA-Z0-9- ]+ Switch Software Version/', $sysDescr)) {
    $os = 'comware';
} elseif (starts_with($sysObjectId, '.1.3.6.1.4.1.25506.11.1')) {
    $os = 'comware';
}
