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
     * Get one session from ID.
     *
     * @param int $sessionId Session ID to get.
     *
     * @return array
     */
    public function findOneById(int $sessionId): array
    {
        return Session::with('owner')
            ->with('students')
            ->where('id', '=', $sessionId)
            ->get()
            ->all()
        ;
    }

    /**
     * Find all sessions.
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