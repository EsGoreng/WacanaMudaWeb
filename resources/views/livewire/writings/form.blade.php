<div>

    <form wire:submit="save">
        <div class="flex flex-row justify-between items-center mb-4 sm:mb-6 w-full mx-auto">
            <flux:button variant="primary" icon="arrow-left" :href="route('dashboard.writing')">
                <span class="hidden sm:inline">Back</span>
            </flux:button>

            <flux:button variant="primary" icon="cloud" type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">{{ $writing ? 'Update Article' : 'Save Article' }}</span>
                <span wire:loading wire:target="save">Saving...</span>
            </flux:button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-start py-12">

            <div class="lg:col-span-8 space-y-4 sm:space-y-6">
                <div
                    class="sm:bg-white sm:dark:bg-gray-900 sm:rounded-xl sm:shadow-sm sm:ring-1 sm:ring-gray-950/5 sm:dark:ring-white/10 sm:p-6">

                    <h2
                        class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3 mb-4 sm:mb-5 px-2 sm:px-0">
                        Article Content
                    </h2>

                    <div class="flex flex-col gap-5 sm:gap-6">
                        {{ $this->form->getComponent('featured_image') }}
                        {{ $this->form->getComponent('image_preview') }}

                        <div class="mt-2">
                            {{ $this->form->getComponent('content') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-4 sm:space-y-6 mt-8">
                <div
                    class="sm:bg-white sm:dark:bg-gray-900 sm:rounded-xl sm:shadow-sm sm:ring-1 sm:ring-gray-950/5 sm:dark:ring-white/10 sm:p-6">
                    <h2
                        class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3 mb-4 sm:mb-5 px-2 sm:px-0">
                        Publishing Info
                    </h2>

                    <div class="flex flex-col gap-4 sm:gap-5">
                        {{ $this->form->getComponent('title') }}
                        {{ $this->form->getComponent('description') }}
                        {{ $this->form->getComponent('categories') }}
                        {{ $this->form->getComponent('series_id') }}

                        <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                            {{ $this->form->getComponent('status') }}
                        </div>

                        <div class="pt-1">
                            {{ $this->form->getComponent('is_anonymous') }}
                        </div>

                        <div class="hidden">
                            {{ $this->form->getComponent('slug') }}
                            {{ $this->form->getComponent('image_credit') }}
                            {{ $this->form->getComponent('image_credit_url') }}
                            {{ $this->form->getComponent('unsplash_photo_id') }}
                            {{ $this->form->getComponent('unsplash_download_location') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <x-filament-actions::modals />
</div>
