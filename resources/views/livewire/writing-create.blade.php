<div>
    <form wire:submit="create">
        <div class="flex flex-row justify-between items-center mb-4 w-full mx-auto">
            <flux:button icon="arrow-left" :href="route('dashboard.writing')">
                Back
            </flux:button>
            <flux:button variant="primary" icon="cloud" type="submit">
                Save
            </flux:button>
        </div>

        {{ $this->form }}

    </form>

    <x-filament-actions::modals />
</div>
