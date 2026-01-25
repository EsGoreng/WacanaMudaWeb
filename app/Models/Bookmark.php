<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    protected $guarded = [];

    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }
}
