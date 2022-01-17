<?php

namespace App\Model;

class RoleRepository
{
    /**
     * Get one role from tag.
     *
     * @param string $tag Tag
     *
     * @return mixed
     */
    public function findOneByTag(string $tag)
    {
        return Role::where('tag', '=', $tag)
            ->get()
            ->first();
    }
}