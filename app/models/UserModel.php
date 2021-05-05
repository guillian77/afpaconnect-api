<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

class UserModel
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $database)
    {
        $this->db = $database;
    }

    public function findOneByUsername($username)
    {
        return $this->db->getConnection()
            ->table('users')
            ->where('user_identifier', '=', $username)
            ->orWhere('user_mailPro', '=', $username)
            ->orWhere('user_mailPerso', '=', $username)
            ->get()
            ->first();
    }
}
