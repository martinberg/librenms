<?php

$dnos_objectid = array(
    '.1.3.6.1.4.1.6027.1.',
    '.1.3.6.1.4.1.674.10895.3042',
    '.1.3.6.1.4.1.674.10895.3044',
    '.1.3.6.1.4.1.674.10895.3045',
    '.1.3.6.1.4.1.674.10895.3046',
    '.1.3.6.1.4.1.674.10895.3053',
    '.1.3.6.1.4.1.674.10895.3054',
    '.1.3.6.1.4.1.674.10895.3055',
    '.1.3.6.1.4.1.674.10895.3056',
    '.1.3.6.1.4.1.674.10895.3057',
    '.1.3.6.1.4.1.674.10895.3058',
    '.1.3.6.1.4.1.674.10895.3059',
    '.1.3.6.1.4.1.674.10895.3060',
    '.1.3.6.1.4.1.674.10895.3061',
    '.1.3.6.1.4.1.674.10895.3066',
);

if (starts_with($sysObjectId, $dnos_objectid)) {
    $os = 'dnos';
}

unset($dnos_objectid);
