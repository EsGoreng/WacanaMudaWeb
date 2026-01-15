<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Writing extends Model
{
    use HasFactory;

    protected $primaryKey = 'writing_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'series_id',
        'title',
        'slug',
        'content',
        'description',
        'featured_image',
        'image_credit',
        'image_credit_url',
        'featured_image_url',
        'unsplash_photo_id',
        'unsplash_download_location',
        'reading_time',
        'is_anonymous',
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function getAuthorDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }

        return $this->user->name ?? 'Unknown';
    }

    public function getAuthorAvatarUrlAttribute()
    {
        if ($this->is_anonymous) {
            return 'https://ui-avatars.com/api/?name=Anonymous&background=random&color=fff';
        }

        return $this->user && $this->user->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->user->name ?? 'U');
    }

    public function getImageUrlAttribute(): string
    {
        \Log::info('getImageUrlAttribute called:', [
            'featured_image' => $this->featured_image,
            'starts_with_https' => $this->featured_image ? str_starts_with($this->featured_image, 'https://images.unsplash.com') : false,
        ]);

        if ($this->featured_image && str_starts_with($this->featured_image, 'https://images.unsplash.com')) {
            \Log::info('Returning Unsplash URL:', ['url' => $this->featured_image]);

            return $this->featured_image;
        }

        if ($this->featured_image) {
            $url = Storage::disk('public')->url($this->featured_image);
            \Log::info('Returning Storage URL:', ['url' => $url]);

            return $url;
        }

        $placeholder = asset('https://placehold.co/600x400/1e232e/FFF?text=No+Image');
        \Log::info('Returning placeholder:', ['url' => $placeholder]);

        return $placeholder;
    }

    public function getPhotographerNameAttribute(): ?string
    {
        return $this->image_credit;
    }

    public function getPhotographerUrlAttribute(): ?string
    {
        return $this->image_credit_url;
    }

    public function getUnsplashImageAttribute(): bool
    {
        return ! empty($this->unsplash_photo_id);
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 120);
    }
}
