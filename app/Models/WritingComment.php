<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WritingComment extends Model
{
    protected $fillable = ['user_id', 'writing_id', 'body'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function writing(): BelongsTo
    {
        return $this->belongsTo(Writing::class, 'writing_id', 'writing_id');
    }
}
