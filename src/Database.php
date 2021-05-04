<?php


namespace App\Core;


use Exception;
use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @param string $db_host
     * @param int $db_port
     * @param string $db_name
     * @param string $db_username
     * @param string $db_password
     */
    public function __construct(string $db_host, int $db_port, string $db_name, string $db_username, string $db_password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name",$db_username,$db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function fetchAll(string $query): array
    {
        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

}
