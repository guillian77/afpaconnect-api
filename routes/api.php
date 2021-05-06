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
Router::get('/api/users', [\App\Api\User::class, 'getAll'], 'api.users', 'Authenticate');
Router::get('/api/centers', [\App\Api\User::class, 'getAll'], 'api.centers.get', 'Authenticate');

/*
|--------------------------------------------------------------------------
| SIMULATION
|--------------------------------------------------------------------------
| Here are emulated routes for development only.
| Static data will be provided.
*/
Router::get('/api/simulation', [\App\Api\Simulation::class, 'getUser'], 'api.simulation');
Router::get('/api/simulationblank', [\App\Api\Simulation::class, 'getBlankUser'], 'api.simulationblank');
