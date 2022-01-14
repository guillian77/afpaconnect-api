<?php

namespace App\Model;

use App\Core\Database\EloquentDriver;
use Illuminate\Database\Query\Builder;

class SessionRepository
{
    private EloquentDriver $driver;
    private Builder $qb;

    public function __construct(EloquentDriver $driver)
    {
        $this->driver = $driver;
        $this->qb = $driver->getConnection()->table('sessions');
    }

    /**
     * Get all sessions.
     *
     * @param $sessionId
     *
     * @return array
     */
    public function findOneById($sessionId): array
    {
        return Session::with('owner')
            ->with('students')
            ->where('id', '=', $sessionId)
            ->get()
            ->all()
        ;
    }

    /**
     * Find one session by owner.
     *
     * @return mixed
     */
    public function findAll()
    {
        return Session::with('owner')
            ->with('students')
            ->get()
            ->all()
        ;
    }
}