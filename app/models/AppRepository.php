<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;

/**
 * Class AppRepository
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class AppRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db, App $app)
    {
        $this->db = $db;
        $this->app = $app;

    }
}
