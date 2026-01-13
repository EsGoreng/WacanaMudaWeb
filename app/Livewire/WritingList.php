<?php

namespace App\Livewire;

use App\Models\Writing;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class WritingList extends Component
{
    use WithPagination;

    #[Computed]
    public function posts()
    {
        return Writing::with(['user', 'category']) // Eager loading relasi user
            ->where('status', 'published')         // Hanya yang published
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(9);
    }

    public function paginationView()
    {
        return 'pagination.flux-theme';
    }

    public function render()
    {
        return view('livewire.writing-list');
    }
}
