<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'user_id',
        'event_name',
        'location',
        'event_date',
        'status',
        'type',
    ];

    public static function findByUid(string $eventId)
    {
        return self::query()->where('uid', $eventId)->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
