<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BookmarkService
{
    /**
     * Toggle bookmark status (Add if not exists, Remove if exists)
     */
    public function toggleBookmark(User $user, Model $model): bool
    {

        $exists = Bookmark::where('user_id', $user->id)
            ->where('bookmarkable_id', $model->getKey())
            ->where('bookmarkable_type', get_class($model))
            ->exists();

        if ($exists) {

            Bookmark::where('user_id', $user->id)
                ->where('bookmarkable_id', $model->getKey())
                ->where('bookmarkable_type', get_class($model))
                ->delete();

            return false;
        } else {

            Bookmark::create([
                'user_id' => $user->id,
                'bookmarkable_id' => $model->getKey(),
                'bookmarkable_type' => get_class($model),
            ]);

            return true;
        }
    }

    /**
     * Cek apakah item sedang di-bookmark oleh user
     */
    public function isBookmarked(User $user, Model $model): bool
    {
        return Bookmark::where('user_id', $user->id)
            ->where('bookmarkable_id', $model->getKey())
            ->where('bookmarkable_type', get_class($model))
            ->exists();
    }

    /**
     * Ambil daftar Writings yang dibookmark user
     */
    public function getBookmarkedWritings(User $user)
    {

        return \App\Models\Writing::whereHas('bookmarks', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with(['user', 'categories'])
            ->latest('created_at')
            ->paginate(5, ['*'], 'writingsPage');
    }

    /**
     * Ambil daftar Forums yang dibookmark user
     */
    public function getBookmarkedForums(User $user)
    {
        return \App\Models\Forum::whereHas('bookmarks', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with(['user', 'categories'])
            ->withCount('comments')
            ->latest()
            ->paginate(5, ['*'], 'forumsPage');
    }

    /**
     * Ambil daftar Events yang dibookmark user
     */
    public function getBookmarkedEvents(User $user)
    {
        return \App\Models\Event::whereHas('bookmarks', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with(['categories'])
            ->latest()
            ->paginate(5, ['*'], 'eventsPage');
    }
}
