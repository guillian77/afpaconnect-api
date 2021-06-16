<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

/**
 * Class FinancialRepository
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class FinancialRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    
}
