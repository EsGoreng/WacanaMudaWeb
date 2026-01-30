<?php

namespace App\Livewire\LandingPage;

use App\Livewire\BaseDataTable;
use App\Models\LandingPageSetting;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;

class Editor extends BaseDataTable
{
    public ?array $data = [];

    public function mount(): void
    {

        $settings = LandingPageSetting::firstOrCreate();

        $this->form->fill($settings->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Builder::make('content')
                    ->label('Landing Page Sections')
                    ->columnSpanFull()
                    ->reorderableWithButtons()
                    ->collapsible()
                    ->cloneable()
                    ->blocks([

                        Block::make('about_section')
                            ->label('About Us')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextInput::make('section_title')
                                    ->default('ABOUT US')
                                    ->required(),

                                FileUpload::make('image')
                                    ->label('About Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('landing-page/about')
                                    ->required(),

                                RichEditor::make('content')
                                    ->label('Content')
                                    ->required(),

                                Toggle::make('is_visible')->default(true),
                            ]),
                        Block::make('vision_mission_section')
                            ->label('Visi & Misi')
                            ->icon('heroicon-m-flag')
                            ->schema([
                                TextInput::make('section_title')
                                    ->default('VISI & MISI')
                                    ->required(),

                                Textarea::make('vision')
                                    ->label('Pernyataan Visi')
                                    ->rows(3)
                                    ->required(),

                                Repeater::make('missions')
                                    ->label('Daftar Misi')
                                    ->schema([
                                        Textarea::make('value')
                                            ->label('Poin Misi')
                                            ->rows(2)
                                            ->required(),
                                    ])
                                    ->defaultItems(3),

                                Toggle::make('is_visible')->default(true),
                            ]),

                        Block::make('pillars_section')
                            ->label('3 Pillars')
                            ->icon('heroicon-m-building-library')
                            ->schema([
                                TextInput::make('section_title')->default('3 Pillars'),
                                Repeater::make('items')
                                    ->schema([
                                        TextInput::make('title')->required(),
                                        Textarea::make('description')->required(),
                                    ])
                                    ->grid(3)
                                    ->maxItems(3),
                                Toggle::make('is_visible')->default(true),
                            ]),
                        Block::make('gallery_section')
                            ->label('Dokumentasi Kegiatan')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                TextInput::make('section_title')
                                    ->label('Judul Seksi')
                                    ->default('DOKUMENTASI')
                                    ->required(),

                                Textarea::make('section_subtitle')
                                    ->label('Deskripsi Singkat')
                                    ->rows(2),

                                Repeater::make('items')
                                    ->label('Daftar Foto/Video')
                                    ->schema([
                                        FileUpload::make('media_file')
                                            ->label('File (Foto/Video)')
                                            ->disk('public')
                                            ->directory('landing-page/gallery')
                                            ->acceptedFileTypes(['image/*', 'video/mp4', 'video/quicktime'])
                                            ->maxSize(10240) // Max 10MB
                                            ->required(),

                                        TextInput::make('caption')
                                            ->label('Keterangan (Opsional)')
                                            ->placeholder('Contoh: Kegiatan Bakti Sosial'),

                                        Toggle::make('is_wide')
                                            ->label('Tampilan Lebar?')
                                            ->default(false)
                                            ->helperText('Jika aktif, item akan mengambil 2 kolom di grid.'),
                                    ])
                                    ->grid(3)
                                    ->collapsible(),

                                Toggle::make('is_visible')->default(true),
                            ]),
                        Block::make('latest_writings_section')
                            ->label('Tulisan Terbaru (Feed)')
                            ->icon('heroicon-m-newspaper')
                            ->schema([
                                TextInput::make('section_title')
                                    ->label('Judul Seksi')
                                    ->default('TULISAN TERBARU')
                                    ->required(),

                                Textarea::make('section_subtitle')
                                    ->label('Deskripsi Singkat')
                                    ->rows(2),

                                TextInput::make('limit')
                                    ->label('Jumlah Tulisan Ditampilkan')
                                    ->numeric()
                                    ->default(4)
                                    ->minValue(2)
                                    ->maxValue(4)
                                    ->required(),

                                Toggle::make('show_author')
                                    ->label('Tampilkan Penulis')
                                    ->default(true),

                                Toggle::make('is_visible')->default(true),
                            ]),
                        Block::make('events_section')
                            ->label('Agenda Kegiatan (Events)')
                            ->icon('heroicon-m-calendar-days')
                            ->schema([
                                TextInput::make('section_title')
                                    ->label('Judul Seksi')
                                    ->default('AGENDA KEGIATAN')
                                    ->required(),

                                Textarea::make('section_subtitle')
                                    ->label('Deskripsi Singkat')
                                    ->rows(2),

                                TextInput::make('limit')
                                    ->label('Jumlah Event Ditampilkan')
                                    ->numeric()
                                    ->default(4)
                                    ->minValue(4)
                                    ->maxValue(6)
                                    ->required(),

                                Toggle::make('is_visible')->default(true),
                            ]),

                    ]),
            ])
            ->statePath('data');
    }

    public function save()
    {

        $state = $this->form->getState();

        $settings = LandingPageSetting::first();
        if ($settings) {
            $settings->update($state);
        } else {
            LandingPageSetting::create($state);
        }

        Notification::make()
            ->title('Landing page updated successfully')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.landing-page.editor');
    }
}
