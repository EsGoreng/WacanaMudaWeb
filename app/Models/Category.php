<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function badgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->name) {
                    'Ruang Kata' => 'bg-blue-600',
                    'Jelajah Rasa' => 'bg-pink-600',
                    'Jejak Karya' => 'bg-emerald-600',
                    default => 'bg-zinc-600',
                };
            }
        );
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Writing::class, 'category_id');
    }
}
