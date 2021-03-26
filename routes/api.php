<?php

use App\Core\Facade\Router;
use App\Utility\Response;

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


Router::get('/api/users', function () { Response::resp('API not implemented yet.', 400, true); }, 'api.users');
Router::get('/api/centers', function () { Response::resp('API not implemented yet.', 400, true); }, 'api.centers.get');
