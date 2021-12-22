<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;
use Illuminate\Support\Collection;

/**
 * Class SessionRepository
 * @package App\Model
 * @author Lucas Campillo
 * @version 1.0
 */
class SessionRepository
{
    private EloquentDriver $db;

    public function __construct(EloquentDriver $db)
    {
        $this->db = $db;
    }

    /**
     * @param $formationId
     * @return mixed
     */
    public function findByFormation($formationId)
    {
        return Session::where('formation_id', '=', $formationId)->get();
    }

    /**
     * @param $formationsIds
     * @param $dateBefore
     * @param $dateAfter
     * @return Collection
     */
    public function findByFormationsAndDate($formationsIds, $dateBefore, $dateAfter): Collection
    {
        $qb = $this->db->getConnection()->table('sessions');

        $qb->whereIn('formation_id', $formationsIds);

        if ($dateBefore && $dateAfter) {
            $qb->whereBetween('start_at', [$dateBefore, $dateAfter]);
            $qb->whereBetween('end_at', [$dateBefore, $dateAfter]);
        }

        return $qb->get();
    }
}
