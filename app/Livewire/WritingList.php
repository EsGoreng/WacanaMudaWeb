<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Writing;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class WritingList extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: [])]
    public $selectedCategories = [];

    #[Url(except: 'latest')]
    public $sortBy = 'latest';

    #[Url(except: '')]
    public $dateFrom = '';

    #[Url(except: '')]
    public $dateTo = '';

    #[Url(except: '')]
    public $readingTimeMin = '';

    #[Url(except: '')]
    public $readingTimeMax = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function updatingReadingTimeMin()
    {
        $this->resetPage();
    }

    public function updatingReadingTimeMax()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $categorySlug = request()->query('category');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $this->selectedCategories = [$category->category_id];
                $this->category = '';
            }
        }
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'selectedCategories',
            'sortBy',
            'dateFrom',
            'dateTo',
            'readingTimeMin',
            'readingTimeMax',
        ]);
        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {

        $query = Writing::with(['user', 'categories'])
            ->where('status', 'Published')
            ->whereNotNull('published_at');

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $searchTerm = '%'.$this->search.'%';
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        if (! empty($this->selectedCategories) && count($this->selectedCategories) > 0) {
            $query->whereHas('categories', function ($q) {

                $q->whereIn('categories.category_id', $this->selectedCategories);
            });
        }

        if (! empty($this->dateFrom)) {
            $query->whereDate('published_at', '>=', $this->dateFrom);
        }
        if (! empty($this->dateTo)) {
            $query->whereDate('published_at', '<=', $this->dateTo);
        }

        if (! empty($this->readingTimeMin)) {
            $query->where('reading_time', '>=', $this->readingTimeMin);
        }
        if (! empty($this->readingTimeMax)) {
            $query->where('reading_time', '<=', $this->readingTimeMax);
        }

        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'popular':
                $query->latest('published_at');
                break;
            default:
                $query->latest('published_at');
                break;
        }

        return $query->paginate(9);
    }

    #[Computed]
    public function categories()
    {

        $query = Category::whereHas('writings', function ($q) {
            $q->where('status', 'Published')
                ->whereNotNull('published_at');

            if (! empty($this->search)) {
                $searchTerm = '%'.$this->search.'%';
                $q->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('content', 'like', $searchTerm);
                });
            }
        });

        $query->withCount(['writings' => function ($q) {
            $q->where('status', 'Published')
                ->whereNotNull('published_at');

            if (! empty($this->search)) {
                $searchTerm = '%'.$this->search.'%';
                $q->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('content', 'like', $searchTerm);
                });
            }
        }]);

        return $query->orderBy('name')->get();
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
