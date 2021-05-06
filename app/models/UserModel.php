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

    private function getReferencesWithoutColumns(string $table, array $filters)
    {
        $reference = $this->db->getConnection()
            ->table($table)
            ->first()
        ;

        $reference = (array) $reference;

        foreach ($filters as $filter) {
            unset($reference[$filter]);
        }

        return array_keys($reference);
    }

    public function findAll()
    {
        $columns = $this->getReferencesWithoutColumns('users', ['user_password']);
        return $this->db->getConnection()
            ->table('users')
            ->select($columns)
            ->get();
    }

    public function findOneByUsername($username)
    {
        return $this->db->getConnection()
            ->table('users')
            ->where('user_identifier', '=', $username)
            ->orWhere('user_mailPro', '=', $username)
            ->orWhere('user_mailPerso', '=', $username)
            ->first();
    }
}
