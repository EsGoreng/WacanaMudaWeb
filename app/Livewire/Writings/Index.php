<?php

namespace App\Livewire\Writings;

use App\Models\Category;
use App\Models\Writing;
use App\Traits\InteractsWithContentFilters;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use InteractsWithContentFilters;
    use WithPagination;

    #[Url(except: '')]
    public $readingTimeMin = '';

    #[Url(except: '')]
    public $readingTimeMax = '';

    public function updatingReadingTimeMin()
    {
        $this->resetPage();
    }

    public function updatingReadingTimeMax()
    {
        $this->resetPage();
    }

    public function resetCustomFilters()
    {
        $this->reset(['readingTimeMin', 'readingTimeMax']);
    }

    public function mount()
    {
        $categorySlug = request()->query('category');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $this->selectedCategories = [$category->category_id];
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
            ->withCount(['likes'])
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

            case 'popular':
                $query->orderByDesc('view_count');
                break;

            case 'most_liked':
                $query->orderByDesc('likes_count');
                break;

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            default:
                $query->latest('published_at');
                break;
        }

        return $query->paginate(6);
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

    public function render()
    {

        $literacyContent = \Illuminate\Support\Arr::random([
            [
                'heading' => 'Critical <span class="font-serif italic font-medium text-black dark:text-white ml-1">Minds</span>',
                'quote' => 'Encouraging analytical thinking and the power of reason to navigate through modern complexities.',
            ],
            [
                'heading' => 'The Sanctuary of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Discourse</span>',
                'quote' => 'A dedicated space to nurture ideas, test logic, and maintain healthy intellectual debates.',
            ],
            [
                'heading' => 'Literacy as <span class="font-serif italic font-medium text-black dark:text-white ml-1">Foundation</span>',
                'quote' => 'Building deep awareness that reading and writing are the fundamental roots of all education.',
            ],
            [
                'heading' => 'Ink, Logic & <span class="font-serif italic font-medium text-black dark:text-white ml-1">Expression</span>',
                'quote' => 'Providing a canvas for every thought, turning abstract ideas into written masterpieces.',
            ],
            [
                'heading' => 'The Light of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Wisdom</span>',
                'quote' => 'Illuminating the darkest corners of ignorance with the steady torch of knowledge.',
            ],
            [
                'heading' => 'Cultivating the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Intellect</span>',
                'quote' => 'A mind stretched by a new idea never returns to its original dimensions.',
            ],
            [
                'heading' => 'The Alchemy of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Words</span>',
                'quote' => 'Transforming the base metal of raw information into the gold of profound understanding.',
            ],
            [
                'heading' => 'Architects of the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Future</span>',
                'quote' => 'Today’s readers are tomorrow’s leaders. We write the future one page at a time.',
            ],
            [
                'heading' => 'Bridging <span class="font-serif italic font-medium text-black dark:text-white ml-1">Perspectives</span>',
                'quote' => 'Literature allows us to live a thousand lives and view the world through a thousand eyes.',
            ],
            [
                'heading' => 'The Mirror of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Humanity</span>',
                'quote' => 'Reading holds up a mirror to nature, reflecting our shared struggles, triumphs, and complexities.',
            ],
            [
                'heading' => 'Voices from the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Past</span>',
                'quote' => 'Books are the legacy that a great genius leaves to mankind, delivered down from generation to generation.',
            ],
            [
                'heading' => 'Pathways to <span class="font-serif italic font-medium text-black dark:text-white ml-1">Liberty</span>',
                'quote' => 'Literacy is the road map to freedom; without it, we are lost in a maze of someone else’s making.',
            ],
            [
                'heading' => 'Sharper than <span class="font-serif italic font-medium text-black dark:text-white ml-1">Steel</span>',
                'quote' => 'The pen shapes history with a permanence that the sword can only envy but never emulate.',
            ],
            [
                'heading' => 'The Quiet <span class="font-serif italic font-medium text-black dark:text-white ml-1">Revolution</span>',
                'quote' => 'In the silence of reading, a loud revolution of ideas begins to take shape.',
            ],
            [
                'heading' => 'Vessels of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Imagination</span>',
                'quote' => 'There is no frigate like a book to take us lands away, nor any coursers like a page of prancing poetry.',
            ],
            [
                'heading' => 'The Art of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Inquiry</span>',
                'quote' => 'To question is to grow. Answers end the journey, but questions keep the path alive.',
            ],
            [
                'heading' => 'Unlocking <span class="font-serif italic font-medium text-black dark:text-white ml-1">Universes</span>',
                'quote' => 'Libraries are the only places where you can travel through time and space without leaving your seat.',
            ],
            [
                'heading' => 'Fueling the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Spark</span>',
                'quote' => 'Curiosity is the wick in the candle of learning; literacy is the flame that lights it.',
            ],
            [
                'heading' => 'Guardians of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Veracity</span>',
                'quote' => 'In a world of noise, literacy teaches us to listen for the whisper of truth.',
            ],
            [
                'heading' => 'The Symphony of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Syntax</span>',
                'quote' => 'Finding the rhythm in structure and the melody in meaning, composing clarity out of chaos.',
            ],
            [
                'heading' => 'Decoding the <span class="font-serif italic font-medium text-black dark:text-white ml-1">World</span>',
                'quote' => 'To read is to empower oneself with the tools to decode the complex systems of our reality.',
            ],
            [
                'heading' => 'Beyond the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Surface</span>',
                'quote' => 'True literacy is diving deep beneath the waves of text to find the pearls of meaning hidden below.',
            ],
            [
                'heading' => 'Weaving the <span class="font-serif italic font-medium text-black dark:text-white ml-1">Narrative</span>',
                'quote' => 'We are all stories in the end; literacy gives us the agency to write our own chapters.',
            ],
            [
                'heading' => 'Legacy of <span class="font-serif italic font-medium text-black dark:text-white ml-1">Letters</span>',
                'quote' => 'Writing is the painting of the voice, preserving our fleeting thoughts for eternity.',
            ],
        ]);

        return view('livewire.writings.index', [
            'literacyContent' => $literacyContent,
            'totalAuthors' => \App\Models\User::count(),
        ]);
    }
}
