<?php

namespace App\Livewire;

use App\Models\Series;
use App\Models\Writing;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class WritingCreate extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'status' => 'draft',
            'is_anonymous' => false,
            'user_id' => auth()->id(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
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
                                                        'curl' => [
                                                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                                                        ],
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
                                                                                        <span class='text-xs text-gray-500 truncate'>
                                                                                            by {$userName} on Unsplash
                                                                                        </span>
                                                                                    </div>
                                                                                </div>";

                                                            $valueData = json_encode([
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

                                            $imageUrl = $imageData['url'];
                                            $downloadLocation = $imageData['download_location'];

                                            try {
                                                Http::withOptions(['verify' => false])
                                                    ->get($downloadLocation, [
                                                        'client_id' => env('UNSPLASH_ACCESS_KEY'),
                                                    ]);

                                                $imageContent = Http::get($imageUrl)->body();

                                                $filename = 'unsplash-'.Str::random(10).'.jpg';
                                                $path = 'writings/featured-images/'.$filename;

                                                Storage::disk('public')->put($path, $imageContent);

                                                $set('featured_image', $path);
                                                $set('image_credit', $imageData['user_name']);
                                                $set('image_credit_url', $imageData['user_link']);

                                                Notification::make()
                                                    ->title('Image imported successfully')
                                                    ->body("Photo by {$imageData['user_name']}")
                                                    ->success()
                                                    ->send();

                                            } catch (\Exception $e) {
                                                Notification::make()
                                                    ->title('Failed to download image')
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
                                ->toolbarButtons([
                                    ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'code', 'link'],
                                    ['h1', 'h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
                                    ['bulletList', 'orderedList', 'blockquote', 'horizontalRule'],
                                    ['details', 'grid', 'table'],
                                    ['attachFiles', 'highlight', 'textColor'],
                                    ['clearFormatting', 'undo', 'redo'],
                                ])
                                ->floatingToolbars([
                                    'paragraph' => [
                                        'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                                    ],
                                    'heading' => [
                                        'h1', 'h2', 'h3',
                                    ],
                                    'table' => [
                                        'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                                        'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                                        'tableMergeCells', 'tableSplitCell',
                                        'tableToggleHeaderRow', 'tableToggleHeaderCell',
                                        'tableDelete',
                                    ],
                                ])
                                ->fileAttachmentsDirectory('writings/attachments')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                ->fileAttachmentsMaxSize(5120)
                                ->resizableImages()
                                ->columns(1)
                                ->extraInputAttributes([
                                    'style' => 'min-height: 20rem;',
                                ]),
                        ]),

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

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->hidden()
                                ->maxLength(255)
                                ->unique(Writing::class, 'slug')
                                ->disabled()
                                ->dehydrated(false)
                                ->helperText('URL-friendly version of the title (auto-generated)')
                                ->columnSpanFull(),

                            Select::make('category_id')
                                ->label('Category')
                                ->options(fn () => \App\Models\Category::pluck('name', 'category_id'))
                                ->required()
                                ->searchable()
                                ->columnSpanFull()
                                ->preload(),
                            Select::make('series_id')
                                ->label('Series')
                                ->options(function () {
                                    return Series::where('user_id', auth()->id())
                                        ->pluck('name', 'series_id');
                                })
                                ->searchable()
                                ->preload()
                                ->columnSpanFull()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    Textarea::make('description')
                                        ->rows(3),
                                ]),

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Draft' => 'Draft',
                                    'Published' => 'Published',
                                    'Archived' => 'Archived',
                                ])
                                ->required()
                                ->default('draft'),

                            Toggle::make('is_anonymous')
                                ->label('Anonymoys Post')
                                ->inline(false)
                                ->default(false),

                            DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->hidden()
                                ->helperText('Kosongkan untuk auto-set saat status published'),

                            TextInput::make('image_credit')
                                ->hidden()
                                ->dehydrated(),

                            TextInput::make('image_credit_url')
                                ->hidden()
                                ->dehydrated(),
                        ])
                        ->grow(false)
                        ->columns(2),

                ])->from('md'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['slug'])) {
            Notification::make()
                ->title('Error: Slug tidak dapat dibuat')
                ->danger()
                ->send();

            return;
        }

        $data['user_id'] = auth()->id();

        if ($data['status'] === 'Published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (! empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['reading_time'] = max(1, ceil($wordCount / 200));
        }

        try {
            Writing::create($data);

            Notification::make()
                ->title('Artikel berhasil dibuat')
                ->success()
                ->send();

            redirect()->route('dashboard.writing');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error saat menyimpan artikel')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        redirect()->route('dashboard.writing');
    }

    public function render(): View
    {
        return view('livewire.writing-create');
    }
}
