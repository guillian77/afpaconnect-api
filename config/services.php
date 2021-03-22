<?php


use App\Core\Conf;

return [
    'db.host' => \DI\env('db_host', Conf::get('db_host')),
    'db.name' => \DI\env('db_name', Conf::get('db_name')),
    'db.username' => \DI\env('db_username', Conf::get('db_username')),
    'db.password' => \DI\env('db_password', Conf::get('db_password')),
    \App\Core\Database::class => \DI\create()->constructor(
                                    Conf::get('db_host'),
                                    Conf::get('db_name'),
                                    Conf::get('db_username'),
                                    Conf::get('db_password')
                                )
];
