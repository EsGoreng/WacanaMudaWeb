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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
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
                Section::make('Buat Diskusi Baru')
                    ->description('Klik disini untuk membuka formulir pembuatan topik')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Diskusi')
                            ->placeholder('Apa yang ingin Anda tanyakan?')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Hidden::make('slug'),

                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
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

                        // --- TAMBAHKAN TOMBOL DI SINI ---
                        // Ini akan merender file blade yang berisi tombol flux
                        View::make('components.submit-button')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
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
