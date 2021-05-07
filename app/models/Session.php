<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class Session extends Model
{
    const TABLE = 'sessions';

    protected $table = self::TABLE;
}
