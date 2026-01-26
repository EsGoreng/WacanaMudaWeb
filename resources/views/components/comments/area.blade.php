@props(['comments', 'parentCommentId'])

<div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">

    <h3
        class="text-lg font-medium text-zinc-900 dark:text-slate-100 mb-6 border-b border-zinc-200 dark:border-slate-800 pb-2">
        Comments <span class="text-zinc-500 dark:text-slate-500 text-sm ml-1">({{ $comments->total() }})</span>
    </h3>

    @auth
        <div class="mb-8 flex gap-3">
            <div class="shrink-0">
                <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    class="w-8 h-8 rounded-full border border-zinc-200 dark:border-zinc-700">
            </div>
            <div class="w-full max-w-full">
                <form wire:submit="createComment">
                    {{ $this->commentForm }}

                    <div class="flex justify-end mt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="bg-brand-hover hover:bg-accent text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                            <span wire:loading.remove wire:target="createComment">Post Comment</span>
                            <span wire:loading wire:target="createComment">Posting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <div class="space-y-6">
        @forelse($comments as $comment)
            <x-comments.item :comment="$comment" :parentCommentId="$parentCommentId" :depth="0" />
        @empty
        @endforelse
    </div>

    <div class="mt-6">
        @if ($comments instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $comments->links() }}
        @endif
    </div>
</div>
