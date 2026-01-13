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

class WritingEdit extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public Writing $writing;

    public function mount(Writing $writing): void
    {
        $this->writing = $writing;

        if ($writing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->form->fill($writing->toArray());
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
                                        ->label('Search at Unsplash')
                                        ->form([
                                            Select::make('unsplash_id')
                                                ->label('Search Image')
                                                ->getOptionLabelUsing(fn ($value) => $value)
                                                ->searchable()
                                                ->placeholder('Write a search keyword (example: technology...)')
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
                                                            $url = $result['urls']['regular'];
                                                            $thumb = $result['urls']['thumb'];
                                                            $desc = Str::limit($result['alt_description'] ?? 'Unsplash Image', 30);
                                                            $user = $result['user']['name'];

                                                            return [$url => "
                                                                            <div class='flex flex-row items-center gap-4' style='padding: 4px; width: 100%;'>
                                                                                <div style='width: 80px; height: 80px; flex-shrink: 0;'>
                                                                                    <img src='{$thumb}' style='
                                                                                        width: 100%; 
                                                                                        height: 100%; 
                                                                                        object-fit: cover; 
                                                                                        border-radius: 8px;
                                                                                        border: 1px solid #e5e7eb;
                                                                                    ' />
                                                                                </div>
                                                                                
                                                                                <div class='flex flex-col justify-center' style='overflow: hidden;'>
                                                                                    <span class='font-bold text-sm text-gray-800 dark:text-gray-200 truncate' style='display: block;'>
                                                                                        {$desc}
                                                                                    </span>
                                                                                    <span class='text-xs text-gray-500 truncate'>
                                                                                        by {$user}
                                                                                    </span>
                                                                                    <span class='text-[10px] text-gray-400 mt-1'>
                                                                                        Click to select
                                                                                    </span>
                                                                                </div>
                                                                            </div>"];
                                                        });
                                                })
                                                ->allowHtml()
                                                ->required(),
                                        ])
                                        ->action(function (array $data, Set $set) {
                                            $imageUrl = $data['unsplash_id'];

                                            try {
                                                $imageContent = Http::get($imageUrl)->body();

                                                $filename = 'unsplash-'.Str::random(10).'.jpg';
                                                $path = 'writings/featured-images/'.$filename;

                                                Storage::disk('public')->put($path, $imageContent);

                                                $set('featured_image', $path);

                                                Notification::make()
                                                    ->title('The image was successfully taken from Unsplash.')
                                                    ->success()
                                                    ->send();

                                            } catch (\Exception $e) {
                                                Notification::make()
                                                    ->title('Failed to download image, please try again.')
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
                                ->maxLength(255)
                                ->hidden()
                                ->disabled()
                                ->dehydrated(false)
                                ->helperText('URL-friendly version of the title (auto-generated)')
                                ->columnSpanFull(),

                            Select::make('category_id')
                                ->label('Category')
                                ->options(fn () => \App\Models\Category::pluck('name', 'category_id'))
                                ->required()
                                ->searchable()
                                ->preload()
                                ->columnSpanFull(),

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
                                ->label('Anonymous Post')
                                ->inline(false)
                                ->default(false),

                            DateTimePicker::make('published_at')
                                ->label('Published Date')
                                ->hidden()
                                ->helperText('Leave empty to auto-set when status is published'),
                        ])
                        ->grow(false)
                        ->columns(2),

                ])->from('md'),
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        $data = $this->form->getState();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['slug'])) {
            Notification::make()
                ->title('Error: Slug cannot be generated')
                ->danger()
                ->send();

            return;
        }

        if ($data['status'] === 'Published' && empty($data['published_at']) && $this->writing->status !== 'Published') {
            $data['published_at'] = now();
        }

        if (! empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['reading_time'] = max(1, ceil($wordCount / 200));
        }

        try {
            $this->writing->update($data);

            Notification::make()
                ->title('Article updated successfully')
                ->success()
                ->send();

            redirect()->route('dashboard.writing');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error updating article')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function cancel(): void
    {
        redirect()->route('dashboard.writing');
    }

    public function render(): View
    {
        return view('livewire.writing-edit');
    }
}
