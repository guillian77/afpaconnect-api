<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

/**
 * Class FormationRepository
 * @package App\Model
 * @author Lucas Campillo
 * @version 1.0
 */
class FormationRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    
}
