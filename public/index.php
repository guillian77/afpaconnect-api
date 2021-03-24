<?php
namespace App\Core;


define('ROOT', dirname(__DIR__) . '/');
define('SRC', ROOT.'src/');
define('APP', ROOT.'app/');
define('CONTROLLER', ROOT.'app/controllers/');
define('MODEL', ROOT.'app/models/');
define('MIDDLEWARE', ROOT.'app/middlewares/');
define('WWW', ROOT.'public/');
define('VIEWS', ROOT.'app/views/');
define('CACHE', ROOT.'storage/cache/');

require ROOT . 'vendor/autoload.php';

App::get()->boot();
