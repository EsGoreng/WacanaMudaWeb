<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

                    'Technology' => 'bg-blue-600 text-white',
                    'Programming' => 'bg-indigo-600 text-white',
                    'Web Development' => 'bg-sky-600 text-white',
                    'Mobile Development' => 'bg-cyan-600 text-white',
                    'Design' => 'bg-fuchsia-600 text-white',
                    'Business' => 'bg-amber-600 text-white',
                    'Finance' => 'bg-emerald-600 text-white',
                    'Politics' => 'bg-red-600 text-white',
                    'Education' => 'bg-teal-600 text-white',
                    'Lifestyle' => 'bg-pink-500 text-white',
                    'Productivity' => 'bg-lime-600 text-white',
                    'Opinion' => 'bg-zinc-700 text-white',
                    'Social' => 'bg-violet-600 text-white',
                    'Career' => 'bg-orange-600 text-white',
                    'Creative Writing' => 'bg-purple-600 text-white',
                    'Tutorial' => 'bg-blue-500 text-white',
                    'Review' => 'bg-rose-600 text-white',
                    'News & Update' => 'bg-slate-700 text-white',
                    'Romance' => 'bg-rose-500 text-white',
                    'Poetry' => 'bg-purple-500 text-white',
                    'Short Story' => 'bg-indigo-500 text-white',
                    'Fiction' => 'bg-violet-700 text-white',
                    'Slice of Life' => 'bg-emerald-500 text-white',
                    'Diary' => 'bg-teal-500 text-white',
                    'Personal Thoughts' => 'bg-zinc-600 text-white',
                    'Healing' => 'bg-green-500 text-white',
                    'Letters' => 'bg-amber-500 text-white',
                    'Quotes' => 'bg-sky-500 text-white',
                    'Fantasy' => 'bg-purple-700 text-white',
                    'Drama' => 'bg-red-500 text-white',
                    'Coming of Age' => 'bg-lime-500 text-white',
                    'Random Thoughts' => 'bg-neutral-600 text-white',

                    default => 'bg-zinc-500 text-white',
                };
            }
        );
    }

    public function forums(): BelongsToMany
    {
        return $this->belongsToMany(
            Forum::class,
            'category_forum',
            'category_id',
            'forum_id'
        );
    }

    public function writings(): BelongsToMany
    {
        return $this->belongsToMany(
            Writing::class,
            'category_writing',
            'category_id',
            'writing_id'
        );
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(
            Event::class,
            'category_event',
            'category_id',
            'event_id'
        );
    }
}
