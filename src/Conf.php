<?php

namespace App\Core;


class Conf
{
    public static function get($key)
    {
        $config = require ROOT . 'config/configuration.php';

        return (array_key_exists($key, $config)) ? $config[$key] : null;
    }
}
