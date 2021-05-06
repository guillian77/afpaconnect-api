<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Center
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class Center extends Model
{
    protected $table = 'centers';

    protected $primaryKey = 'id';

    protected $hidden = [
        'id'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}
