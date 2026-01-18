<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'parent_id',
        'user_id',
        'body',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forum(): BelongsTo
    {
        return $this->belongsTo(Forum::class);
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getScoreAttribute(): int
    {
        return $this->votes()->where('type', 'up')->count() -
               $this->votes()->where('type', 'down')->count();
    }
}
