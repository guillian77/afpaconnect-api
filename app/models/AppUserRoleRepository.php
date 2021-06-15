<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

/**
 * Class CenterRepository
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class AppUserRoleRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        return $this->db->getConnection()
            ->table('apps__users__roles')
            ->get();
    }
}
