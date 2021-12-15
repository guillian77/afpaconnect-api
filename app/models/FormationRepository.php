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

    /**
     * Get columns names for a table.
     */
    public function getFormationsByUser($userId)
    {
        $qb = $this->db->getConnection()->table('users__sessions');
        $qb
            ->select('formations.id')
            ->addSelect('formations.tag')
            ->addSelect('formations.status')
            ->join('sessions','sessions.id', '=', 'users__sessions.session_id')
            ->join('formations','formations.id', '=', 'sessions.formation_id')
            ->where('users__sessions.user_id', '=', $userId);


        return $qb->get();
    }
    
}
