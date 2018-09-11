<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

use LibreNMS\Authentication\LegacyAuth;

header('Content-type: text/plain');

if (!LegacyAuth::user()->hasGlobalAdmin()) {
    die('ERROR: You need to be admin');
}

dbUpdate(array('value' => '2'), 'callback', '`name` = "enabled"', array());
