<?php

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
Router::get('/', [\App\Controller\UserManageController::class, 'index'], 'home', 'Authenticate');

/*
|----------------------------
| USER
|----------------------------
*/
Router::get('/login', [\App\Controller\LoginController::class, 'index'], 'login');
Router::post('/login', [\App\Controller\LoginController::class, 'login'], 'login.post');
Router::get('/logout', [\App\Controller\LogoutController::class, 'index'], 'logout', 'Authenticate');
Router::get('/user-manage', [\App\Controller\UserManageController::class, 'index'], 'user.manage', 'Authenticate');
Router::post('/user-edit', [\App\Controller\UserManageController::class, 'edit'], 'user.edit', 'Authenticate');
Router::get('/user-upload', [\App\Controller\UserUploadController::class, 'index'], 'user.upload', 'Authenticate');
Router::post('/users-uploaded', [\App\Controller\UserUploadController::class, 'upload'], 'users.uploaded', 'Authenticate');
Router::post('/user-add', [\App\Controller\UserUploadController::class, 'add'], 'user.add', 'Authenticate');

/*
|----------------------------
| EXTERNALS
|----------------------------
*/
Router::get('/register/enable', [\App\Controller\RegisterController::class, 'enable'], 'register.enable');
