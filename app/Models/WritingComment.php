<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WritingComment extends Model
{
    protected $fillable = ['user_id', 'writing_id', 'parent_id', 'body'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function writing(): BelongsTo
    {
        return $this->belongsTo(Writing::class, 'writing_id', 'writing_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(WritingComment::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(WritingComment::class, 'parent_id');
    }
}
