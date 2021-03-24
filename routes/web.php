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
Router::get('/', function() { echo "Ma page d'accueil !"; }, 'home');

/*
|----------------------------
| USER
|----------------------------
*/
Router::get('/login', [\App\Controller\LoginController::class, 'index'], 'login');
Router::get('/logout', [\App\Controller\LogoutController::class, 'index'], 'logout', 'Authenticate');
Router::get('/user-manage', [\App\Controller\UserManageController::class, 'index'], 'user.manage');
Router::get('/user-upload', [\App\Controller\UserUploadController::class, 'index'], 'user.upload');
