<?php

use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\UserManageController;
use App\Controller\UserUploadController;
use App\Core\Facade\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Now create something great!
|
*/

/*
|----------------------------
| MAIN
|----------------------------
*/
Router::get('/', [UserManageController::class, 'index'], 'home', 'Authenticate');


/*
|----------------------------
| ROLES
|----------------------------
*/

Router::post('/apps-roles-edit', [\App\Controller\RoleController::class, 'appsRolesEdit'], 'apps.roles.edit');
Router::post('/roles-edit', [\App\Controller\RoleController::class, 'edit'], 'roles.edit');
Router::post('/role-create', [\App\Controller\RoleController::class, 'create'], 'role.create');
Router::get('/role-manage', [\App\Controller\RoleController::class, 'index'], 'role.manage', 'Authenticate');


/*
|----------------------------
| USER
|----------------------------
*/
Router::get('/login', [LoginController::class, 'index'], 'login');
Router::post('/login', [LoginController::class, 'login'], 'login.post');
Router::get('/logout', [LogoutController::class, 'index'], 'logout', 'Authenticate');
Router::get('/user-manage', [UserManageController::class, 'index'], 'user.manage', 'Authenticate');
Router::post('/user-edit', [UserManageController::class, 'edit'], 'user.edit', 'Authenticate');
Router::get('/user-upload', [UserUploadController::class, 'index'], 'user.upload', 'Authenticate');
Router::post('/users-uploaded', [UserUploadController::class, 'upload'], 'users.uploaded', 'Authenticate');
Router::post('/user-add', [UserUploadController::class, 'add'], 'user.add', 'Authenticate');

/*
|----------------------------
| EXTERNALS
|----------------------------
*/
Router::get('/register/enable', [\App\Controller\RegisterController::class, 'enable'], 'register.enable');
