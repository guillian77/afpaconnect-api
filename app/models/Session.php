<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Session
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class Session extends Model
{
    const TABLE = 'sessions';
    public $timestamps = false;
    protected $guarded = [];

    protected $table = self::TABLE;

    /**
     * Session have an owner.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner');
    }

    /**
     * Session have many students.
     *
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users__sessions', 'session_id', 'user_id');
    }
}
