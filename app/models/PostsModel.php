<?php


namespace App\Model;


use App\Core\Database;

class PostsModel
{
    /**
     * @var Database
     */
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findAll(): array
    {
        return $this->database->fetchAll('SELECT * FROM tickets');
    }
}
