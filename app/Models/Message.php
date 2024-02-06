<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
      'content',
      'room_id'
    ];

    public function interlocutor(): BelongsTo
    {
        return $this->belongsTo(Interlocutor::class);
    }
}
