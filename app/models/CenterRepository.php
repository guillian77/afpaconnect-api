<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

/**
 * Class CenterRepository
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class CenterRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        return $this->db->getConnection()
            ->table('centers')
            ->get();
    }
}
