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
 */
class User extends Model
{
    // TODO: Invert foreign key to this format: 'tableName_id'. Better for Eloquent ORM.
    // TODO: Verify current database structure to be the same of this Model.

    protected $table = 'users';

    protected $hidden = [
        'id'
    ];

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
    { // TODO: Fix this with belongsToMany
        return $this->hasMany(App::class, 'id');
    }

    public function roles()
    {
        return $this
            ->belongsToMany(Role::class, 'apps__users__roles', 'id_user', 'id_role')
            ->withPivot('id_role', 'id_app')
        ;
    }

    public function financial()
    { // TODO: Make refactoring on database to correspond with a simple relation (current is many to many).
        return $this->belongsTo(Financial::class, 'id');
    }
}
