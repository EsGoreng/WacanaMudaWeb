<?php

namespace App\Services;

use App\Models\Comment;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    /**
     * Create a new comment (Polymorphic)
     */
    public function createComment(Model $model, string $body, ?int $parentId = null): Comment
    {

        return $model->comments()->create([
            'user_id' => Auth::id(),
            'body' => $body,
            'parent_id' => $parentId,
        ]);
    }

    /**
     * Update an existing comment
     */
    public function updateComment(Comment $comment, string $body, int $userId): bool
    {
        if ($comment->user_id !== $userId) {
            Notification::make()
                ->title('Unauthorized')
                ->danger()
                ->send();

            return false;
        }

        $updated = $comment->update(['body' => $body]);

        if ($updated) {
            Notification::make()->title('Comment updated')->success()->send();
        }

        return $updated;
    }

    /**
     * Delete a comment
     */
    public function deleteComment(Comment $comment, $user): bool
    {
        $isAdmin = method_exists($user, 'hasAnyRole')
            ? $user->hasAnyRole(['superadmin', 'admin'])
            : false;

        if ($comment->user_id === $user->id || $isAdmin) {
            $comment->delete();

            Notification::make()
                ->title('Comment deleted')
                ->success()
                ->send();

            return true;
        }

        return false;
    }
}
