<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id'; 

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    
    public function articles(): HasMany
    {
        return $this->hasMany(Writing::class, 'category_id');
    }
}