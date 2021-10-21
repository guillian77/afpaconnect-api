<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class AppUserRole
 * @package App\Model
 * @author Moreau Eloïse
 * @version 1.0
 *
 * @method static where(\Closure|string|array  $column, mixed  $operator, mixed  $value)
 */
class AppUserRole extends Model
{
    protected $table = 'apps__users__roles';

    protected $primaryKey = ['user_id', 'app_id', 'role_id'];

    protected $fillable = ['user_id', 'app_id', 'role_id'];

    // Disable timestamps: created_at, updated_at
    public $timestamps = false;
}

