<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 *
 * @method static where(\Closure|string|array  $column, mixed  $operator, mixed  $value)
 * @property bool|mixed password
 */
class User extends Model
{
    protected $table = 'users';

    protected $hidden = [
        'id'
    ];

    // Protected columns.
    protected $guarded = [
        'id',
        'identifier'
    ];

    /**
     * Password mutator.
     *
     * Easy register hashed password inside database.
     *
     * @param $password
     *
     * @return $this
     */
    public function setPasswordAttribute($password) : self
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_ARGON2I);

        return $this;
    }

    public function career()
    { // TODO: Add a relation 'career_id' inside 'user' table.
        return $this->belongsTo(Career::class, 'id');
    }

    public function session()
    { // TODO: Add a relation 'session_id' inside 'user' table.
        return $this->belongsTo(Session::class, 'id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'id');
    }

    public function apps()
    {
        return $this->belongsToMany(App::class, 'apps__users__roles');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'apps__users__roles')
            ->withPivot('role_id', 'app_id');
    }

    public function financial()
    { // TODO: Make refactoring on database to correspond with a simple relation (current is many to many).
        return $this->belongsTo(Financial::class, 'id');
    }
}
