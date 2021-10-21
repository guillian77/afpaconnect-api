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
 * @property string|mixed password User password.
 * @property string|mixed password_temp Temp password for user app registering phase.
 * @property string|mixed $mail1
 * @property string|mixed $mail2
 */
class User extends Model
{
    protected $table = 'users';

    protected $hidden = [
        'password',
        'password_temp'
    ];

    // Protected columns.
    protected $guarded = [
        'id'
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
        return $this->belongsToMany(Session::class, 'users__sessions','user_id','session_id');
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

    /**
     * Check if user has role on specific app.
     *
     * @param int $app The app ID.
     *
     * @return bool
     */
    public function hasApp(int $app): bool
    {
        $hasApp = $this->apps()
            ->where('app_id', '=', $app)
            ->get()
            ->first();

        if (!is_null($hasApp)) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has role on specific app.
     *
     * @param int $app App ID.
     * @param int $role Role ID.
     *
     * @return bool
     */
    public function hasAppRole(int $app, int $role): bool
    {
        $hasRole = $this->roles()
            ->where('app_id', '=', $app)
            ->where('role_id', '=', $role)
            ->get()
            ->first();

        if (!is_null($hasRole)) {
            return true;
        }

        return false;
    }

    public function getUsername()
    {
        return (empty($user->mail1)) ? $this->mail2 : $this->mail1;
    }
}
