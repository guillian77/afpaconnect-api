<?php


use App\Core\Conf;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    'db.host' => \DI\env('db_host', Conf::get('db_host')),
    'db.port' => \DI\env('db_port', Conf::get('db_port')),
    'db.name' => \DI\env('db_name', Conf::get('db_name')),
    'db.username' => \DI\env('db_username', Conf::get('db_username')),
    'db.password' => \DI\env('db_password', Conf::get('db_password')),
    \App\Core\Database::class => \DI\create()->constructor(
                                    Conf::get('db_host'),
                                    Conf::get('db_port'),
                                    Conf::get('db_name'),
                                    Conf::get('db_username'),
                                    Conf::get('db_password')
                                ),
    FilesystemLoader::class => \DI\create()->constructor(VIEWS),
    Environment::class => \DI\create()->constructor(
                                    \DI\get(FilesystemLoader::class),
                                    [
                                        'cache' => STORAGE.'cache/',
                                        'auto_reload' => (Conf::get('env') === 'dev') ?? true,
                                        'strict_variables' => (Conf::get('env') === 'dev') ?? true,
                                        'debug' => true
                                    ]
                                )
];
