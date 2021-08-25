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
| USERS
|--------------------------------------------------------------------------
*/
Router::get('/api/login', [\App\Api\LoginApi::class, 'login'], 'api.login');
Router::get('/api/user', [\App\Api\UserApi::class, 'getOneByUsername'], 'api.user');
Router::get('/api/users', [\App\Api\UserApi::class, 'getAll'], 'api.users');
Router::post('/api/user-edit', [\App\Api\UserApi::class, 'edit'], 'api.user.edit', 'Authenticate');

Router::post('/api/register', [\App\Api\RegisterApi::class, 'register'], 'api.register');

/*
|--------------------------------------------------------------------------
| CENTERS
|--------------------------------------------------------------------------
*/
Router::get('/api/centers', [\App\Api\CenterApi::class, 'getAll'], 'api.centers');
Router::get('/api/formations', [\App\Api\FormationApi::class, 'getAll'], 'api.formations');
Router::get('/api/financials', [\App\Api\FinancialApi::class, 'getAll'], 'api.financials');
Router::get('/api/apps', [\App\Api\AppApi::class, 'index'], 'api.apps');
Router::get('/api/roles', [\App\Api\RoleApi::class, 'index'], 'api.roles');
Router::get('/api/apps/roles', [\App\Api\AppApi::class, 'getRoles'], 'api.apps.roles');

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
