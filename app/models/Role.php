<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Role
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class Role extends Model
{
    protected $table = 'roles';

    protected $hidden = [
        'id',
        'pivot'
    ];

    /**
     * Role has many users.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
