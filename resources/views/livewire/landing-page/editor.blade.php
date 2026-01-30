<div
    class="p-6 bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 max-w-full">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Landing Page</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Customize the sections and content of your welcome page.
        </p>
    </div>

    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-colors flex items-center gap-2">

                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span>Save Changes</span>
            </button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
