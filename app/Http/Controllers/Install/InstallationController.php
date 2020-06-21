<?php
/**
 * InstallationController.php
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use LibreNMS\DB\Eloquent;

class InstallationController extends Controller
{
    protected $connection = 'setup';
    protected $step;
    protected $steps = [
        'checks' => \App\Http\Controllers\Install\ChecksController::class,
        'database' => \App\Http\Controllers\Install\DatabaseController::class,
        'user' => \App\Http\Controllers\Install\MakeUserController::class,
        'finish' => \App\Http\Controllers\Install\FinalizeController::class,
    ];

    public function redirectToIncomplete()
    {
        foreach ($this->stepStatus() as $step => $complete) {
            if (!$complete) {
                return redirect()->route("install.$step");
            }
        }

        return redirect()->route('install.checks');
    }

    public function invalid()
    {
        abort(404);
    }

    public function stepsCompleted()
    {
        return response()->json($this->stepStatus());
    }

    /**
     * Init step info and return false if previous steps have not been completed.
     *
     * @return bool
     */
    final protected function initInstallStep()
    {
        if (is_string(config('librenms.install'))) {
            $this->steps = array_intersect_key($this->steps, array_flip(explode(',', config('librenms.install'))));
        }
        $this->configureDatabase();

        foreach ($this->stepStatus() as $step => $completed) {
            if ($step == $this->step) {
                return true;
            }

            if (!$completed) {
                return false;
            }
        }

        return false;
    }

    final protected function markStepComplete()
    {
        session(["install.$this->step" => true]);
        session()->save();
    }

    final protected function formatData($data = [])
    {
        $data['steps'] = $this->hydrateControllers();
        return $data;
    }

    protected function configureDatabase()
    {
        $db = session('db');
        if (!empty($db)) {
            Eloquent::setConnection(
                $this->connection,
                $db['host'] ?? 'localhost',
                $db['username'] ?? 'librenms',
                $db['password'] ?? null,
                $db['database'] ?? 'librenms',
                $db['port'] ?? 3306,
                $db['socket'] ?? null,
            );
            config(['database.default', $this->connection]);
        }
    }

    private function hydrateControllers()
    {
        $this->steps = array_map(function ($class) {
            return is_object($class) ? $class : app()->make($class);
        }, $this->steps);
    }

    private function stepStatus()
    {
        $this->hydrateControllers();
        return array_map(function ($controller) {
            return $controller->complete();
        }, $this->steps);
    }
}
