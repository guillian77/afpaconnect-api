<?php


namespace App\Model;


use App\Core\Database;

class UserModel
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Find one user by column name.
     * @param $key
     * @param $value
     */
    public function findOneBy($key, $value)
    {
        $stmt = $this->database->getPdo()->query('SELECT * FROM users')->fetch();
    }

    public function findOneByUsername($username)
    {
        $stmt = $this->database->getPdo()->prepare(
            'SELECT * FROM users WHERE user_identifier = :username OR user_mailPro =:username OR user_mailPerso =:username'
        );
        $stmt->bindParam("username", $username);
        $stmt->execute();
        return $stmt->fetch();
    }
}
