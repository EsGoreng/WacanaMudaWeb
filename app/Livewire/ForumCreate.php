<?php

namespace App\Livewire;

use App\Models\Forum;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Component;

class ForumCreate extends Component implements HasActions, HasForms
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
                TextInput::make('title')
                    ->label('Judul Diskusi')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                    ->maxLength(255),

                Hidden::make('slug'),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name') // Pastikan relasi di model benar
                    ->searchable()
                    ->preload()
                    ->required(),

                RichEditor::make('body')
                    ->label('Konten')
                    ->required()
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 'bulletList', 'codeBlock', 'blockquote',
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->model(Forum::class);
    }

    public function create()
    {
        $data = $this->form->getState();

        $data['user_id'] = auth()->id();

        Forum::create($data);

        return redirect()->route('forum')->with('status', 'Forum berhasil dibuat!');
    }

    public function render()
    {
        return view('livewire.forum-create');
    }
}
