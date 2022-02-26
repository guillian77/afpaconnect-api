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
Router::post('/api/auth', [\App\Api\AuthApi::class, 'auth'], 'api.auth');

/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
*/
Router::get('/api/login', [\App\Api\LoginApi::class, 'login'], 'api.login');
Router::get('/api/user', [\App\Api\UserApi::class, 'getOneByUsername'], 'api.user.one');
Router::get('/api/users', [\App\Api\UsersApi::class, 'users'], 'api.user.all');
Router::get('/api/user/table', [\App\Api\UserTableApi::class, 'table'], 'api.user.table', 'Authenticate');
Router::get('/api/user/teachers', [\App\Api\UserTeacherApi::class, 'teachers'], 'api.user.teachers', 'Authenticate');

Router::post('/api/user/edit', [\App\Api\UserEditApi::class, 'edit'], 'api.user.edit', 'Authenticate');
Router::post('/api/register', [\App\Api\RegisterApi::class, 'register'], 'api.register');
Router::post('/api/enable', [\App\Api\EnableApi::class, 'enable'], 'api.enable');

/*
|--------------------------------------------------------------------------
| GET ALL
|--------------------------------------------------------------------------
*/
Router::get('/api/centers', [\App\Api\CenterApi::class, 'index'], 'api.centers');
Router::get('/api/formations', [\App\Api\FormationApi::class, 'index'], 'api.formations');
Router::get('/api/financials', [\App\Api\FinancialApi::class, 'financials'], 'api.financials');
Router::get('/api/apps', [\App\Api\AppApi::class, 'index'], 'api.apps');
Router::get('/api/roles', [\App\Api\RoleApi::class, 'roles'], 'api.roles');
Router::get('/api/apps/roles', [\App\Api\AppApi::class, 'getRoles'], 'api.apps.roles');
Router::get('/api/session', [\App\Api\SessionApi::class, 'session'], 'api.session');
Router::get('/api/sessions', [\App\Api\SessionApi::class, 'sessions'], 'api.sessions');

/*
|--------------------------------------------------------------------------
| MESSAGES
|--------------------------------------------------------------------------
*/
Router::get('/api/messages', [\App\Api\MessagesApi::class, 'read'], 'api.messages', 'Authenticate');
Router::post(
    '/api/message/create',
    [\App\Api\MessagesApi::class, 'create'],
    'api.messages.create',
    'Authenticate'
);
