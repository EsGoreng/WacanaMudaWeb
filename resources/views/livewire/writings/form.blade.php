<div>
    <form wire:submit="save">
        <div class="flex flex-row justify-between items-center mb-4 w-full mx-auto">
            <flux:button variant="primary" icon="arrow-left" :href="route('dashboard.writing')">
                Back
            </flux:button>

            <flux:button variant="primary" icon="cloud" type="submit">
                {{ $writing ? 'Update Article' : 'Save Article' }}
            </flux:button>
        </div>

        {{ $this->form }}

    </form>

    <x-filament-actions::modals />
</div>
