<?php

namespace App\Livewire\Forums;

use App\Models\Forum;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        RichEditor::make('body')
                            ->label('Content')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'link', 'bulletList', 'codeBlock', 'blockquote',
                            ])
                            ->columnSpanFull(),

                        View::make('components.submit-button')
                            ->columnSpanFull(),
                    ]),
                // ->collapsible()
                // ->collapsed(),
            ])
            ->statePath('data')
            ->model(Forum::class);
    }

    public function create()
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        Forum::create($data);

        return redirect()->route('forums')->with('status', 'Forum berhasil dibuat!');
    }

    public function render()
    {
        return view('livewire.forums.create');
    }
}
