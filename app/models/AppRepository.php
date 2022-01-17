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

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    /**
     * Get one App from tag.
     *
     * @param string $tag
     *
     * @return mixed
     */
    public function findOneByTag(string $tag)
    {
        return App::where('tag', '=', $tag)
            ->with('appRoles')
            ->get()
            ->first();
    }
}
