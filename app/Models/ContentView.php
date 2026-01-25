<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContentView extends Model
{
    protected $fillable = ['viewable_id', 'viewable_type', 'created_at'];

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
