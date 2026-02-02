<div class="relative w-full max-w-sm mx-auto">
    <div
        class="relative bg-white dark:bg-zinc-800/50 backdrop-blur-xs rounded-[1rem] transition-all duration-300 shadow-sm">

        <div class="relative aspect-square h-auto w-[full] px-4 pt-4">
            <img alt="Portrait of {{ $user->name }}" class="w-full h-full object-cover object-center rounded-[0.5rem]"
                src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }} " />
        </div>

        <div class="p-6 pt-4">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('profile.show', $user->username) }}" wire:navigate
                    class="hover:underline hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50 tracking-tight">
                        {{ $user->name }}
                    </h2>
                </a>
            </div>

            <div class="text-gray-500 text-sm leading-relaxed mb-4 fi-prose dark:prose-invert prose-sm max-w-none">
                @if ($user->bio)
                    {!! \Illuminate\Support\Str::markdown($user->bio) !!}
                @else
                    No bio available yet.
                @endif
            </div>

            <div class="flex items-center gap-4 mb-6">
                @if ($user->linkedin_url)
                    <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                        class="text-gray-400 hover:text-[#0077b5] transition-colors duration-300">
                        <x-bi-linkedin class="w-5 h-5" />
                    </a>
                @endif

                @if ($user->instagram_url)
                    <a href="{{ $user->instagram_url }}" target="_blank" rel="noopener noreferrer"
                        class="text-gray-400 hover:text-[#E1306C] transition-colors duration-300">
                        <x-bi-instagram class="w-5 h-5" />
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 text-gray-500 font-medium text-sm">
                    <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                        title="Followers">
                        <x-bi-people class="w-4 h-4" />
                        <span>{{ $user->followers_count }}</span>
                    </div>

                    <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                        title="Writings">
                        <x-bi-pen class="w-4 h-4" />
                        <span>{{ $user->writings()->count() }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                        title="Forums">
                        <x-bi-chat-left-text class="w-4 h-4" />
                        <span>{{ $user->forums()->count() }}</span>
                    </div>
                </div>

                @auth
                    @if (Auth::id() === $user->id)
                        {{ $this->editProfile }}
                    @else
                        @php
                            $isFollowing = $user->isFollowedBy(Auth::user());
                        @endphp
                        <button wire:click="toggleFollow" wire:loading.attr="disabled"
                            class=" rounded-xl active:scale-95 duration-300 flex items-center gap-1 font-medium transition-colors
                            {{ $isFollowing
                                ? 'bg-zinc-200 text-zinc-800 hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-600'
                                : 'bg-zinc-600 text-white hover:bg-zinc-700' }}">

                            {{ $isFollowing ? 'Unfollow' : 'Follow' }}

                            @if (!$isFollowing)
                                <span class="text-sm leading-none">+</span>
                            @endif
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="bg-zinc-600 text-white px-5 py-2 rounded-xl active:scale-95 duration-300 flex items-center gap-1 text-sm font-medium hover:bg-zinc-700">
                        Follow
                        <span class="text-lg leading-none">+</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</div>
