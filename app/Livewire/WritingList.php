<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Writing;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class WritingList extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCategories = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategories']);
        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {
        $query = Writing::with(['user', 'category'])
            ->where('status', 'Published')
            ->whereNotNull('published_at');

        // Filter berdasarkan pencarian
        if (! empty($this->search)) {
            $query->where(function ($q) {
                $searchTerm = '%'.$this->search.'%';
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        // Filter berdasarkan kategori yang dipilih
        if (! empty($this->selectedCategories) && count($this->selectedCategories) > 0) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        return $query->latest('published_at')
            ->paginate(9);
    }

    #[Computed]
    public function categories()
    {
        // Ambil hanya kategori yang memiliki artikel published
        return Category::whereHas('writings', function ($query) {
            $query->where('status', 'Published')
                ->whereNotNull('published_at');
        })
            ->withCount(['writings' => function ($query) {
                $query->where('status', 'Published')
                    ->whereNotNull('published_at');
            }])
            ->orderBy('name')
            ->get();
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
