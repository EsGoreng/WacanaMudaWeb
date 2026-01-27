<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait InteractsWithContentFilters
{
    #[Url(except: '')]
    public $search = '';

    #[Url(except: [])]
    public $selectedCategories = [];

    #[Url(except: 'latest')]
    public $sortBy = 'latest';

    #[Url(except: null)]
    public $dateFrom = null;

    #[Url(except: null)]
    public $dateTo = null;

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

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategories', 'sortBy', 'dateFrom', 'dateTo']);

        if (method_exists($this, 'resetCustomFilters')) {
            $this->resetCustomFilters();
        }

        $this->resetPage();
    }
}
