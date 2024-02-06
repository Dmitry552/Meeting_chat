<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'creator'
    ];

    /**
     * @return HasMany
     */
    public function interlocutors(): HasMany
    {
        return $this->hasMany(Interlocutor::class);
    }

    public function messages(): HasManyThrough
    {
        return $this->hasManyThrough(
            Message::class,
            Interlocutor::class,
            'room_id',
            'interlocutor_id',
            'id',
            'id'
        );
    }
}
