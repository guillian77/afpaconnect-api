<?php


namespace App\Core\Database;


use PDO;
use PDOException;

class PdoDriver
{
    private PDO $connection;

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
            $this->connection = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name",$db_username,$db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

}
