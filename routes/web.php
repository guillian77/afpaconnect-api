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
Router::get('/', [\App\Controller\UserManageController::class, 'index'], 'home');

/*
|----------------------------
| USER
|----------------------------
*/
Router::get('/login', [\App\Controller\LoginController::class, 'index'], 'login');
Router::get('/logout', [\App\Controller\LogoutController::class, 'index'], 'logout', 'Authenticate');
Router::get('/user-manage', [\App\Controller\UserManageController::class, 'index'], 'user.manage');
Router::get('/user-upload', [\App\Controller\UserUploadController::class, 'index'], 'user.upload');
