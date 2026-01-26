<?php

namespace App\Livewire\Writings;

use App\Actions\Writing\UpsertWriting;
use App\Models\Category;
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

class Form extends Component implements HasActions, HasSchemas
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
                'categories' => $writing->categories->pluck('category_id')->toArray(),
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

                                                                $attributionHtml = view('components.unsplash-attribution', [
                                                                    'thumb' => $thumb,
                                                                    'desc' => $desc,
                                                                    'userName' => $userName,
                                                                    'likes' => $likes,
                                                                ])->render();

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
                                            if ($featuredImage instanceof TemporaryUploadedFile) {
                                                $imageUrl = $featuredImage->temporaryUrl();
                                            } elseif (is_string($featuredImage) && str_starts_with($featuredImage, 'http')) {
                                                $imageUrl = $featuredImage;
                                            } elseif (is_string($featuredImage)) {
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

                                Select::make('categories')
                                    ->label('Category')
                                    ->multiple()
                                    ->options(Category::all()->pluck('name', 'category_id'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpanFull(),

                                Select::make('series_id')
                                    ->label('Series')
                                    ->options(function () {
                                        $user = auth()->user();

                                        if ($user->hasRole('superadmin')) {

                                            return Series::with('user')->get()->mapWithKeys(function ($series) {
                                                $ownerName = $series->user->name ?? 'Unknown';

                                                return [$series->series_id => $series->name.' - '.$ownerName];
                                            });
                                        }

                                        return Series::where('user_id', $user->id)
                                            ->pluck('name', 'series_id');
                                    })
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

    public function save(UpsertWriting $action): void
    {
        if ($this->writing) {
            $this->authorize('update', $this->writing);
        } else {
            $this->authorize('create', Writing::class);
        }

        $data = $this->form->getState();

        try {
            $action->execute($data, $this->writing);

            $message = $this->writing ? 'Article updated successfully' : 'Article created successfully';

            Notification::make()->title($message)->success()->send();
            redirect()->route('dashboard.writing');

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error saving article')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render(): View
    {
        return view('livewire.writings.form');
    }
}
