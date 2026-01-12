<?php

namespace App\Livewire;

use App\Models\Series;
use App\Models\Writing;
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

        // Check authorization
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
                                ->image()
                                ->directory('writings/featured-images')
                                ->maxSize(2048)
                                ->helperText('Max 2MB')
                                ->columnSpanFull(),

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
                                    'style' => 'min-height: 20rem; max-height: 60vh; overflow-y: auto;',
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
                                ->columnSpanFull()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('slug')
                                        ->required()
                                        ->maxLength(255),
                                    Textarea::make('description')
                                        ->rows(3),
                                ]),

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
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'archived' => 'Archived',
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

        if ($data['status'] === 'published' && empty($data['published_at']) && $this->writing->status !== 'published') {
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
