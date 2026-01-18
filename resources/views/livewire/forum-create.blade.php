<div class="mx-auto p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
    <form wire:submit="create">
        {{ $this->form }}
        <div class="mt-6 flex justify-end">
            <flux:button variant="primary" icon="cloud" type="submit">Post Forum</flux:button>
        </div>
    </form>
</div>
