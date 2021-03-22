<?php


namespace App\Core;


use PDO;
use PHPUnit\Exception;

class Database
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    public function __construct(string $db_host, string $db_name, string $db_username, string $db_password)
    {
        try {
            $this->pdo= new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        } catch (Exception $exception) {
            throw new \Exception($exception);
        }
    }

    public function fetchAll(string $query): array
    {
        return $this->pdo->query($query)->fetchAll();
    }
}
