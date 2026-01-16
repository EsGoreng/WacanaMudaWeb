<?php

namespace App\Livewire;

use App\Models\Series;
use App\Models\Writing;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class WritingForm extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public ?Writing $writing = null;

    public function mount(?Writing $writing = null): void
    {
        if ($writing && $writing->exists) {

            $this->authorize('update', $writing);

            $this->writing = $writing;

            $this->form->fill([
                'title' => $writing->title,
                'slug' => $writing->slug,
                'description' => $writing->description,
                'content' => $writing->content,
                'featured_image' => $writing->featured_image,
                'image_credit' => $writing->image_credit,
                'image_credit_url' => $writing->image_credit_url,
                'unsplash_photo_id' => $writing->unsplash_photo_id,
                'unsplash_download_location' => $writing->unsplash_download_location,
                'category_id' => $writing->category_id,
                'series_id' => $writing->series_id,
                'status' => $writing->status,
                'is_anonymous' => $writing->is_anonymous,
                'published_at' => $writing->published_at,
                'user_id' => $writing->user_id,
                'reading_time' => $writing->reading_time,
            ]);
        } else {

            $this->authorize('create', Writing::class);

            $this->form->fill([
                'status' => 'draft',
                'is_anonymous' => false,
                'user_id' => auth()->id(),
                'image_credit' => null,
                'image_credit_url' => null,
                'unsplash_photo_id' => null,
                'unsplash_download_location' => null,
            ]);
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        Section::make('Article & Blog')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('Featured Image')
                                    ->disk('public')
                                    ->image()
                                    ->live()
                                    ->directory('writings/featured-images')
                                    ->maxSize(2048)
                                    ->helperText('Max 2MB')
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $set('featured_image', $state);
                                    })
                                    ->hintAction(
                                        Action::make('unsplash')
                                            ->icon('heroicon-o-camera')
                                            ->label('Search on Unsplash')
                                            ->form([
                                                Select::make('unsplash_data')
                                                    ->label('Search Photo')
                                                    ->getOptionLabelUsing(fn ($value) => 'Image Selected')
                                                    ->searchable()
                                                    ->placeholder('Type a keyword (e.g. technology)...')
                                                    ->getSearchResultsUsing(function (string $search) {
                                                        $response = Http::withOptions([
                                                            'verify' => false,
                                                            'connect_timeout' => 30,
                                                            'timeout' => 30,
                                                            'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4],
                                                        ])->get('https://api.unsplash.com/search/photos', [
                                                            'query' => $search,
                                                            'per_page' => 10,
                                                            'client_id' => env('UNSPLASH_ACCESS_KEY'),
                                                        ]);

                                                        if ($response->failed()) {
                                                            return [];
                                                        }

                                                        return collect($response->json('results'))
                                                            ->mapWithKeys(function ($result) {
                                                                $thumb = $result['urls']['small'];
                                                                $desc = Str::limit($result['alt_description'] ?? 'Unsplash Image', 50);
                                                                $userName = $result['user']['name'];
                                                                $likes = number_format($result['likes'] ?? 0);

                                                                $attributionHtml = "
<div class='group flex items-center gap-4 p-3 rounded-lg transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50' style='width: 100%;'>
    <div class='relative flex-shrink-0' style='width: 96px; height: 96px;'>
        <img 
            src='{$thumb}' 
            alt='{$desc}'
            class='w-full h-full object-cover rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700 group-hover:ring-2 group-hover:ring-blue-400 transition-all'
            loading='lazy'
        />
        <div class='absolute inset-0 rounded-xl bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity'></div>
    </div>
    <div class='flex-1 min-w-0 space-y-1.5'>
        <h4 class='font-semibold text-sm text-gray-900 dark:text-gray-100 truncate leading-tight'>
            {$desc}
        </h4>
        <div class='flex items-center gap-2 text-xs'>
            <span class='text-gray-600 dark:text-gray-400'>
                by <span class='font-medium text-gray-700 dark:text-gray-300'>{$userName}</span>
            </span>
            <span class='text-gray-400 dark:text-gray-600'>•</span>
            <span class='inline-flex items-center gap-1 text-gray-500 dark:text-gray-400'>
                <svg class='w-3.5 h-3.5' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z' clip-rule='evenodd'/>
                </svg>
                {$likes}
            </span>
        </div>
        <div class='inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400'>
            <svg class='w-3 h-3' fill='currentColor' viewBox='0 0 20 20'>
                <path d='M10 12a2 2 0 100-4 2 2 0 000 4z'/>
                <path fill-rule='evenodd' d='M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z' clip-rule='evenodd'/>
            </svg>
            Unsplash
        </div>
    </div>
</div>";

                                                                $valueData = json_encode([
                                                                    'id' => $result['id'],
                                                                    'url' => $result['urls']['regular'],
                                                                    'download_location' => $result['links']['download_location'],
                                                                    'user_name' => $userName,
                                                                    'user_link' => $result['user']['links']['html'],
                                                                ]);

                                                                return [$valueData => $attributionHtml];
                                                            });
                                                    })
                                                    ->allowHtml()
                                                    ->required(),
                                            ])
                                            ->action(function (array $data, Set $set) {
                                                $imageData = json_decode($data['unsplash_data'], true);
                                                if (! $imageData) {
                                                    return;
                                                }

                                                try {
                                                    $set('featured_image', $imageData['url']);
                                                    $set('image_credit', $imageData['user_name']);
                                                    $set('image_credit_url', $imageData['user_link']);
                                                    $set('unsplash_photo_id', $imageData['id']);
                                                    $set('unsplash_download_location', $imageData['download_location']);

                                                    Notification::make()
                                                        ->title('Image imported successfully')
                                                        ->body('Photo will be attributed to '.$imageData['user_name'])
                                                        ->success()
                                                        ->send();
                                                } catch (\Exception $e) {
                                                    Notification::make()
                                                        ->title('Failed')
                                                        ->body($e->getMessage())
                                                        ->danger()
                                                        ->send();
                                                }
                                            })
                                    ),

                                ViewField::make('image_preview')
                                    ->view('components.image-preview')
                                    ->columnSpanFull()
                                    ->live()
                                    ->viewData(function ($get) {
                                        $imageUrl = null;
                                        $imageCredit = null;
                                        $imageCreditUrl = null;
                                        $isUnsplash = false;

                                        $featuredImage = $get('featured_image');
                                        $imageCredit = $get('image_credit');
                                        $imageCreditUrl = $get('image_credit_url');
                                        $unsplashPhotoId = $get('unsplash_photo_id');

                                        if (empty($featuredImage) && $this->writing && $this->writing->exists) {
                                            $featuredImage = $this->writing->featured_image;
                                            $imageCredit = $this->writing->image_credit;
                                            $imageCreditUrl = $this->writing->image_credit_url;
                                            $unsplashPhotoId = $this->writing->unsplash_photo_id;
                                        }

                                        if (! empty($featuredImage)) {
                                            if (str_starts_with($featuredImage, 'http')) {
                                                $imageUrl = $featuredImage;
                                            } else {
                                                $imageUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($featuredImage);
                                            }
                                        }

                                        $isUnsplash = ! empty($unsplashPhotoId);

                                        return [
                                            'imageUrl' => $imageUrl,
                                            'imageCredit' => $imageCredit,
                                            'imageCreditUrl' => $imageCreditUrl,
                                            'isUnsplash' => $isUnsplash,
                                            'isUpload' => ! empty($imageUrl) && ! $isUnsplash,
                                        ];
                                    }),
                                RichEditor::make('content')
                                    ->label('Content')
                                    ->columnSpanFull()
                                    ->required()
                                    ->fileAttachmentsDirectory('writings/attachments')
                                    ->fileAttachmentsVisibility('public')
                                    ->extraInputAttributes(['style' => 'min-height: 20rem;']),
                            ])
                            ->columnSpan(8),

                        Section::make('Information')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->columnSpanFull(),

                                TextArea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->rows(5)
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->columnSpanFull(),

                                Hidden::make('slug'),

                                Select::make('category_id')
                                    ->label('Category')
                                    ->options(fn () => \App\Models\Category::pluck('name', 'category_id'))
                                    ->required()
                                    ->preload()
                                    ->columnSpanFull(),

                                Select::make('series_id')
                                    ->label('Series')
                                    ->options(fn () => Series::where('user_id', auth()->id())->pluck('name', 'series_id'))
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull()
                                    ->createOptionForm([
                                        TextInput::make('name')->required()->maxLength(255),
                                        Textarea::make('description')->rows(3),
                                    ]),

                                Select::make('status')
                                    ->label('Status')
                                    ->options(['Draft' => 'Draft', 'Published' => 'Published', 'Archived' => 'Archived'])
                                    ->required()
                                    ->default('draft'),

                                Toggle::make('is_anonymous')
                                    ->label('Anonymous Post')
                                    ->default(false),

                                Hidden::make('image_credit')
                                    ->live(),

                                Hidden::make('image_credit_url')
                                    ->live(),

                                Hidden::make('unsplash_photo_id')
                                    ->live(),

                                Hidden::make('unsplash_download_location')
                                    ->live(),
                            ])
                            ->columnSpan(4),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        if ($this->writing) {
            $this->authorize('update', $this->writing);
        } else {
            $this->authorize('create', Writing::class);
        }

        $data = $this->form->getState();

        if (empty($data['featured_image']) && ! empty($data['unsplash_photo_id'])) {
            if ($this->writing && $this->writing->unsplash_photo_id === $data['unsplash_photo_id']) {
                $data['featured_image'] = $this->writing->featured_image;
            }
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        if (empty($data['slug'])) {
            Notification::make()->title('Error: Slug cannot be generated')->danger()->send();

            return;
        }

        if ($data['status'] === 'Published' && empty($data['published_at'])) {
            if (! $this->writing || $this->writing->status !== 'Published') {
                $data['published_at'] = now();

                if (! empty($data['unsplash_download_location'])) {
                    $this->triggerUnsplashDownload($data['unsplash_download_location']);
                }
            }
        }

        if (! empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['reading_time'] = max(1, ceil($wordCount / 200));
        }

        try {
            if ($this->writing) {
                $this->writing->update($data);
                $message = 'Article updated successfully';
            } else {
                $data['user_id'] = auth()->id();
                Writing::create($data);
                $message = 'Article created successfully';
            }

            Notification::make()->title($message)->success()->send();
            redirect()->route('dashboard.writing');

        } catch (\Exception $e) {
            Notification::make()->title('Error saving article')->body($e->getMessage())->danger()->send();
        }
    }

    private function triggerUnsplashDownload(string $downloadLocation): void
    {
        try {
            Http::withOptions([
                'verify' => false,
                'connect_timeout' => 30,
                'timeout' => 30,
                'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4],
            ])->get($downloadLocation, [
                'client_id' => env('UNSPLASH_ACCESS_KEY'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to trigger Unsplash download: '.$e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.writing-form');
    }
}
