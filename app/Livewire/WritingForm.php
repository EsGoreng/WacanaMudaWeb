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
            if ($writing->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            $this->writing = $writing;
            $this->form->fill($writing->toArray());
        } else {
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
                                    ->directory('writings/featured-images')
                                    ->maxSize(2048)
                                    ->helperText('Max 2MB')
                                    ->columnSpanFull()
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
                                                                $desc = Str::limit($result['alt_description'] ?? 'Unsplash Image', 40);
                                                                $userName = $result['user']['name'];

                                                                $attributionHtml = "
                                                            <div class='flex flex-row items-center gap-4' style='padding: 4px; width: 100%;'>
                                                                <div style='width: 80px; height: 80px; flex-shrink: 0;'>
                                                                    <img src='{$thumb}' style='width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;' />
                                                                </div>
                                                                <div class='flex flex-col justify-center overflow-hidden'>
                                                                    <span class='font-bold text-sm truncate' style='display: block;'>{$desc}</span>
                                                                    <span class='text-xs text-gray-500 truncate'>by {$userName} on Unsplash</span>
                                                                </div>
                                                            </div>";

                                                                $valueData = json_encode([
                                                                    'id' => $result['id'],
                                                                    'url' => $result['urls']['regular'], // Hotlink URL
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
                                                    // Simpan data Unsplash untuk trigger download nanti
                                                    $set('featured_image', $imageData['url']); // Hotlink URL
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

                                Hidden::make('published_at'),
                                Hidden::make('image_credit'),
                                Hidden::make('image_credit_url'),
                                Hidden::make('unsplash_photo_id'),
                                Hidden::make('unsplash_download_location'),
                            ])
                            ->columnSpan(4),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

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

                // Trigger Unsplash download saat artikel dipublish
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

    /**
     * Trigger download event ke Unsplash API
     */
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
