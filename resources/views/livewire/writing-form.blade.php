<div>
    <form wire:submit="save">
        <div class="flex flex-row justify-between items-center mb-4 w-full mx-auto">
            <flux:button icon="arrow-left" :href="route('dashboard.writing')"
                class="!bg-slate-900 hover:!bg-slate-900/40 !border-slate-700 !text-white border transition-all">
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
