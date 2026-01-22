<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-3">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>

        <div x-data="{ show: @entangle('isModalOpen') }" x-show="show" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-zinc-500/10 backdrop-blur-sm ransition-opacity" wire:click="closeModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
                    @if ($selectedEvent)
                        <div class="flex flex-col md:flex-row h-full md:h-[600px]">

                            <div class="relative w-full md:w-1/2 h-64 md:h-full">
                                <img src="{{ str_starts_with($selectedEvent->banner_image, 'http') ? $selectedEvent->banner_image : asset('storage/' . $selectedEvent->banner_image) }}"
                                    alt="{{ $selectedEvent->title }}"
                                    class="absolute inset-0 w-full h-full object-cover">
                            </div>

                            <div
                                class="w-full md:w-1/2 p-8 md:p-10 flex flex-col h-full bg-zinc-800 relative overflow-y-auto">

                                <button wire:click="closeModal"
                                    class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                                    <x-bi-x-circle-fill />
                                </button>

                                <div class="flex flex-wrap gap-2 mb-2">
                                    @forelse($event->categories as $category)
                                        <div
                                            class="{{ $category->badgeClass }} px-3 py-1.5 rounded-full border border-black/10 text-xs font-medium text-black transition-colors hover:bg-white/20 cursor-default shadow-sm">
                                            {{ $category->name }}
                                        </div>
                                    @empty
                                        <div
                                            class="bg-black/10 backdrop-blur-sm px-3 py-1.5 rounded-full border border-black/10 text-xs font-medium text-white shadow-sm">
                                            Event
                                        </div>
                                    @endforelse
                                </div>

                                <h2 class="text-3xl font-extrabold text-zinc-950 dark:text-zinc-50 mb-2 leading-tight">
                                    {{ $selectedEvent->title }}
                                </h2>

                                <div class="flex items-center text-zinc-950 dark:text-zinc-300 mb-4 text-sm">
                                    <x-bi-geo class="mr-2 h-5 w-5"></x-bi-geo>
                                    {{ $selectedEvent->location_name }}, {{ $selectedEvent->location_address }}
                                </div>

                                <hr class="border-zinc-100 dark:border-zinc-700 mb-4">

                                <div class="mb-4">
                                    <h3 class="font-bold text-zinc-900 dark:text-zinc-50 mb-2">About this event</h3>
                                    <div class="text-zinc-900 dark:text-zinc-300 text-sm leading-relaxed fi-prose">
                                        {!! $selectedEvent->description !!}
                                    </div>
                                </div>

                                <div
                                    class="mt-auto pt-6 border-t border-zinc-100 dark:border-zinc-700 flex items-center justify-between">
                                    <flux:button variant="primary"
                                        class="bg-brand-hover hover:bg-accent text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                        Register
                                    </flux:button>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="p-10 text-center text-gray-500">
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">
            <div class="p-6 bg-white/5 rounded-xl border border-white/10 text-white">
                <h3 class="font-bold mb-4">Filter & Info</h3>
                <p class="text-sm text-gray-400">Sidebar ini akan tetap terlihat (sticky) saat Anda scroll ke bawah.</p>
            </div>
        </div>
    </div>

</div>
