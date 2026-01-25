<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'avatar',
        'bio',
        'instagram_url',
        'linkedin_url',
        'phone',
        'is_active',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function followings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id');
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id');
    }

    public function isFollowedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function forums(): HasMany
    {
        return $this->hasMany(Forum::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function writings(): HasMany
    {
        return $this->hasMany(Writing::class, 'user_id', 'id');
    }

    public function bookmarkedWritings()
    {
        return $this->morphedByMany(Writing::class, 'bookmarkable', 'bookmarks')
            ->withTimestamps();
    }

    public function bookmarkedEvents()
    {
        return $this->morphedByMany(Event::class, 'bookmarkable', 'bookmarks')
            ->withTimestamps();
    }

    public function bookmarkedForums()
    {
        return $this->morphedByMany(Forum::class, 'bookmarkable', 'bookmarks')
            ->withTimestamps();
    }
}
