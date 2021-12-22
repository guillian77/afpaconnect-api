<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * @package App\Model
 * @author Lucas Campillo
 * @version 1.0
 *
 * @method static where(\Closure|string|array  $column, mixed  $operator, mixed  $value)
 * @property bool|mixed password
 */
class Session extends Model
{
    const TABLE = 'sessions';
    public $timestamps = false;
    protected $guarded = [];

    protected $table = self::TABLE;
}
