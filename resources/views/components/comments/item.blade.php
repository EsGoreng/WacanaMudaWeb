@props(['comment', 'parentCommentId', 'depth' => 0])

@php
    $maxDepth = 2;
    $isTooDeep = $depth >= $maxDepth;
@endphp

<div class="flex flex-col" wire:key="comment-{{ $comment->id }}">

    <div class="flex gap-2 md:gap-3 relative group {{ $isTooDeep ? 'mt-3' : '' }}">

        <div class="flex flex-col items-center shrink-0 w-8">
            <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                class="w-8 h-8 rounded-full object-cover ring-2 ring-white dark:ring-[#0B1416] z-10 relative bg-zinc-100 dark:bg-zinc-800">

            @if (!$isTooDeep && ($comment->children->isNotEmpty() || $parentCommentId === $comment->id))
                <div class="w-0.5 h-full bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px]"></div>
            @endif
        </div>

        <div class="flex-1 min-w-0 pb-2">
            <div class="flex items-center gap-2 text-xs mb-1">
                <a href="{{ route('profile.show', $comment->user) }}"
                    class="font-bold text-zinc-900 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                    {{ $comment->user->name }}
                </a>

                @if ($isTooDeep && $comment->parent)
                    <span class="text-zinc-400">replying to {{ $comment->parent->user->name }}</span>
                @endif

                <span class="text-zinc-500 dark:text-slate-500">•
                    {{ $comment->created_at->diffForHumans(null, true) }}</span>
            </div>

            <div class="prose prose-sm dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300 break-all">
                {!! str($comment->body)->sanitizeHtml() !!}
            </div>

            <div class="flex items-center gap-2 mt-1">
                @auth
                    <button wire:click="setReplyTo({{ $comment->id }})"
                        class="flex items-center gap-1 text-xs font-bold text-zinc-500 dark:text-slate-500 hover:bg-zinc-100 dark:hover:bg-slate-800 px-2 py-2 rounded transition-colors">
                        <x-bi-chat-left class="w-4 h-4" /> Reply
                    </button>

                    @if (auth()->id() === $comment->user_id ||
                            auth()->user()
                                ?->hasAnyRole(['admin', 'superadmin']))
                        <button wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="Are you sure you want to delete this comment?"
                            class="flex items-center gap-1 text-xs text-red-500 hover:text-red-400 hover:bg-zinc-100 dark:hover:bg-slate-800 px-2 py-2 rounded transition-colors">
                            <x-bi-trash class="w-4 h-4" /> Delete
                        </button>
                    @endif
                @endauth
            </div>

            @if ($parentCommentId === $comment->id)
                <div class="mt-3 animate-in fade-in slide-in-from-top-1 pl-0">
                    <form wire:submit="createReply">
                        {{ $this->replyForm }}
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" wire:click="setReplyTo({{ $comment->id }})"
                                class="text-xs text-zinc-500">Cancel</button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-3 rounded-lg text-sm">Reply</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @if ($comment->children->isNotEmpty())
        <div class="flex flex-col w-full">
            @foreach ($comment->children as $child)
                @if ($isTooDeep)
                    <div class="w-full relative" wire:key="child-{{ $child->id }}">
                        <x-comments.item :comment="$child" :parentCommentId="$parentCommentId" :depth="$depth + 1" />
                    </div>
                @else
                    <div class="flex w-full relative" wire:key="child-{{ $child->id }}">
                        <div class="w-8 shrink-0 flex justify-center relative">
                            <div class="w-0.5 h-full bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px]"></div>
                        </div>

                        <div class="flex-1 pl-2 md:pl-4 pt-2">
                            <x-comments.item :comment="$child" :parentCommentId="$parentCommentId" :depth="$depth + 1" />
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
