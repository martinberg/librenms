<?php
/**
 * etherwan.inc.php
 *
 * LibreNMS os poller module for Etherwan 6TX + 2G Managed Switch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2017 Lorenzo Zafra
 * @author     Lorenzo Zafra<zafra@ualberta.ca>
 */

preg_match('~(?\'hardware\'.*?),\sFirmware\srev:\s(?\'version\'.*) \d\d\/\d\d\/\d\d~', $poll_device['sysDescr'], $matches);

if ($matches['hardware']) {
    $hardware = $matches['hardware'];
}

if ($matches['version']) {
    $version = $matches['version'];
}
