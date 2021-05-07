<?php

use App\Core\Facade\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| AUTHENTICATE
|--------------------------------------------------------------------------
*/
Router::post('/api/auth', [\App\Api\Auth::class, 'auth'], 'api.auth');

/*
|--------------------------------------------------------------------------
| GENERAL
|--------------------------------------------------------------------------
| Here are routes only used by the application itself.
*/
Router::get('/api/users', [\App\Api\User::class, 'getAll'], 'api.users');
Router::get('/api/centers', [\App\Api\User::class, 'getAll'], 'api.centers.get');

/*
|--------------------------------------------------------------------------
| SIMULATION
|--------------------------------------------------------------------------
| Here are emulated routes for development only.
| Static data will be provided.
*/

Router::get('/api/sim/success', [\App\Api\Simulation::class, 'success'], 'api.sim.success');
Router::get('/api/sim/success/admin', [\App\Api\Simulation::class, 'success_admin'], 'api.sim.success.admin');
Router::get('/api/sim/success/employee', [\App\Api\Simulation::class, 'success_employee'], 'api.sim.success.employee');
Router::get('/api/sim/success/teacher', [\App\Api\Simulation::class, 'success_teacher'], 'api.sim.success.teacher');
Router::get('/api/sim/success/teacher/admin', [\App\Api\Simulation::class, 'success_teacher_admin'], 'api.sim.success.teacher.admin');
Router::get('/api/sim/success/teacher/superadmin', [\App\Api\Simulation::class, 'success_teacher_superadmin'], 'api.sim.success.teacher.superadmin');

Router::get('/api/sim/blank', [\App\Api\Simulation::class, 'blank'], 'api.simulation.blank');
Router::get('/api/sim/failed', [\App\Api\Simulation::class, 'failed'], 'api.simulation.failed');
Router::get('/api/sim/unfound', [\App\Api\Simulation::class, 'unfound'], 'api.simulation.unfound');

Router::post('/api/sim/inscription', [\App\Api\Simulation::class, 'inscription'], 'api.simulation.inscription');
