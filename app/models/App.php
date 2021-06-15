<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class App
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 *
 * @method static where(\Closure|string|array  $column, mixed  $operator, mixed  $value)
 */
class App extends Model
{
    protected $table = 'apps';

    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'apps__users__roles');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'apps__users__roles');
    }

    public function appRoles()
    {
        return $this->belongsToMany(Role::class, 'apps__roles');
    }
}

