<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Formation
 * @package App\Model
 * @author Lucas Campillo
 * @version 1.0
 */
class Formation extends Model
{
    const TABLE = 'formations';

    public $timestamps = false;

    protected $guarded = [];

    protected $table = self::TABLE;
}