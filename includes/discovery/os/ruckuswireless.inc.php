<?php
/*
 * LibreNMS Ruckus Wireless OS information module
 *
 * Copyright (c) 2015 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * Copyright (c) 2015 Gear Consulting Pty Ltd <github@libertysys.com.au>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if (starts_with($sysObjectId, '.1.3.6.1.4.1.25053.3.1')) {
    $os = 'ruckuswireless';
}
