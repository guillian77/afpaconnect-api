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

    protected $guarded = [];

    // Disable timestamps: created_at, updated_at
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'apps__users__roles');
    }

    public function apps()
    {
        return $this->belongsToMany(App::class, 'apps__users__roles');
    }

    public function rolesApps()
    {
        return $this->belongsToMany(App::class, 'apps__roles');
    }
}
