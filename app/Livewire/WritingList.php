<?php

namespace App\Livewire;

use App\Models\Writing;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class WritingList extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCategory = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {
        return Writing::with(['user', 'category'])
            ->where('status', 'Published')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
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
