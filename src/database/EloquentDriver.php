<?php


namespace App\Core\Database;


use App\Core\App;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use PDO;

class EloquentDriver
{
    private Connection $connection;

    /**
     * EloquentDriver constructor.
     * @param string $db_host
     * @param int $db_port
     * @param string $db_name
     * @param string $db_username
     * @param string $db_password
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(string $db_host, int $db_port, string $db_name, string $db_username, string $db_password)
    {
        $capsule = App::get()
            ->getContainer()
            ->get(Capsule::class);

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $db_host,
            'database'  => $db_name,
            'username'  => $db_username,
            'password'  => $db_password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]);

        $this->connection = $capsule->getConnection();
    }

    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}
