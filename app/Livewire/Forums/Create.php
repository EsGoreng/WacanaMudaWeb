<?php

namespace App\Livewire\Forums;

use App\Models\Category;
use App\Models\Forum;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Make new forum')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('What do you want to ask?')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Hidden::make('slug'),

                        Select::make('categories')
                            ->label('Categories')
                            ->multiple()
                            ->maxItems(3)
                            ->options(Category::all()->pluck('name', 'category_id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        RichEditor::make('body')
                            ->label('Content')
                            ->required()
                            ->fileAttachmentsDirectory('writings/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                'bold', 'italic', 'link', 'bulletList', 'codeBlock', 'blockquote',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_anonymous')
                            ->label('Post as Anonymous')
                            ->default(false)
                            ->columnSpanFull(),

                        View::make('components.submit-button')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data')
            ->model(Forum::class);
    }

    public function create()
    {
        $data = $this->form->getState();

        $categoryIds = $data['categories'] ?? [];
        unset($data['categories']);

        $data['user_id'] = auth()->id();

        $forum = Forum::create($data);

        $forum->categories()->sync($categoryIds);

        return redirect()->route('forums')->with('status', 'Forum berhasil dibuat!');
    }

    public function render()
    {
        return view('livewire.forums.create');
    }
}
