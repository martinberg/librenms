<?php
/**
 * FmTrapLogRateThreshold.php
 *
 * -Description-
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * FortiAnalyzer will send this trap when the received log rate
 * exceeds the suggested rate for the daily rate license.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2019 KanREN, Inc.
 * @author     Heath Barnhart <hbarnhart@kanren.net>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Enum\Severity;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;

class FmTrapLogRateThreshold implements SnmptrapHandler
{
    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param  Device  $device
     * @param  Trap  $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $logRate = $trap->getOidData($trap->findOid('FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmLogRate'));
        $logThresh = $trap->getOidData($trap->findOid('FORTINET-FORTIMANAGER-FORTIANALYZER-MIB::fmLogRateThreshold'));
        $trap->log("Recommended log rate exceeded. Current Rate: $logRate Recommended Rate: $logThresh", Severity::Notice);
    }
}
