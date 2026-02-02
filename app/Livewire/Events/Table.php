<?php

namespace App\Livewire\Events;

use App\Livewire\BaseDataTable;
use App\Models\Category;
use App\Models\Event;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Table extends BaseDataTable
{
    public ?Event $event = null;

    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->query(Event::query()->with('categories'))
            ->heading('Manage Events')
            ->description('This table allows you to manage all of your created events efficiently.')
            ->searchable()
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('description')
                    ->html()
                    ->hidden()
                    ->searchable()
                    ->limit(100),

                TextColumn::make('categories.name')
                    ->badge()
                    ->separator(',')
                    ->limitList(2)
                    ->color('primary'),

                TextColumn::make('location_name')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('location_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50),

                TextColumn::make('start_time')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->getStateUsing(fn ($record) => $record->statusLabel)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Upcoming' => 'success',
                        'Ongoing' => 'warning',
                        'Canceled' => 'danger',
                        'Ended' => 'info',
                    }),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Create')
                    ->icon('heroicon-o-plus')
                    ->closeModalByClickingAway(false)
                    ->schema(fn (Schema $schema) => $this->getEventForm($schema))
                    ->action(function (array $data) {
                        $categoryIds = $data['categories'] ?? [];

                        unset($data['categories']);

                        $data['register_link'] = $data['register_link'] ?? null;

                        $event = Event::create($data);

                        $event->categories()->sync($categoryIds);

                        Notification::make()
                            ->title('Event created successfully')
                            ->success()
                            ->send();
                    })])

            ->recordActions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->closeModalByClickingAway(false)
                    ->schema(fn (Schema $schema) => $this->getEventForm($schema))
                    ->mountUsing(function ($form, Event $record) {
                        $form->fill([
                            ...$record->toArray(),
                            'categories' => $record->categories()->pluck('categories.category_id')->toArray(),
                        ]);
                    })
                    ->form(fn (Schema $schema) => $this->getEventForm($schema))
                    ->action(function (Event $record, array $data) {
                        $categoryIds = $data['categories'] ?? [];
                        unset($data['categories']);

                        if (empty($data['banner_image']) && ! empty($data['unsplash_photo_id'])) {
                            if ($record->unsplash_photo_id === $data['unsplash_photo_id']) {
                                $data['banner_image'] = $record->banner_image;
                            }
                        }

                        $data['register_link'] = $data['register_link'] ?? null;

                        $record->update($data);

                        $record->categories()->sync($categoryIds);

                        Notification::make()
                            ->title('Event updated successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Event $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Event deleted successfully')
                            ->danger()
                            ->send();
                    })])
            ->bulkActions([
                $this->getBulkDeleteAction(),
            ]);
    }

    public function getEventForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Event Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->disabled()
                            ->hidden()
                            ->dehydrated()
                            ->required()
                            ->unique(Event::class, 'slug', ignoreRecord: true),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'ongoing' => 'Ongoing',
                                'canceled' => 'Canceled',
                                'ended' => 'Ended',
                            ])
                            ->default('draft')
                            ->required(),

                        Toggle::make('has_register_link')
                            ->label('Use Registration Link')
                            ->helperText('Enable this if users need to register via an external link.')
                            ->live()
                            ->dehydrated(false)
                            ->default(false)
                            ->afterStateHydrated(fn ($component, $record) => $component->state($record?->register_link !== null)),

                        Toggle::make('is_online')
                            ->label('Online Event?')
                            ->onColor('success')
                            ->offColor('gray')
                            ->live()
                            ->default(false),

                        TextInput::make('meeting_link')
                            ->label('Meeting Link / Join URL')
                            ->placeholder('https://zoom.us/j/...')
                            ->url()
                            ->visible(fn (Get $get) => $get('is_online'))
                            ->required(fn (Get $get) => $get('is_online'))
                            ->columnSpanFull(),

                        TextInput::make('location_name')
                            ->label(fn (Get $get) => $get('is_online') ? 'Platform Name (e.g. Zoom)' : 'Location Name')
                            ->placeholder(fn (Get $get) => $get('is_online') ? 'Zoom, Google Meet, etc.' : 'Gedung Serbaguna...')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('location_address')
                            ->label('Location Address')
                            ->required(fn (Get $get) => ! $get('is_online'))
                            ->hidden(fn (Get $get) => $get('is_online'))
                            ->columnSpanFull(),

                        TextInput::make('register_link')
                            ->label('Register Link')
                            ->placeholder('https://...')
                            ->hint('Can be left blank if there is no need for a link')
                            ->visible(fn (Get $get) => $get('has_register_link'))
                            ->required(fn (Get $get) => $get('has_register_link'))
                            ->url()
                            ->nullable()
                            ->columnSpanFull(),

                        Select::make('categories')
                            ->label('Categories')
                            ->multiple()
                            ->maxItems(3)
                            ->options(Category::all()->pluck('name', 'category_id'))
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),

                        DateTimePicker::make('start_time')
                            ->label('Start Time')
                            ->seconds(false)
                            ->required(),

                        DateTimePicker::make('end_time')
                            ->label('End Time')
                            ->seconds(false)
                            ->after('start_time')
                            ->required(),

                        RichEditor::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('events/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->extraInputAttributes(['style' => 'min-height: 20rem;'])
                            ->required(),

                        TextInput::make('image_credit')->hidden(),
                        TextInput::make('image_credit_url')->hidden(),
                        TextInput::make('unsplash_photo_id')->hidden(),
                        TextInput::make('unsplash_download_location')->hidden(),

                    ])->columns(2),

                Section::make('Banner Image')
                    ->schema([
                        FileUpload::make('banner_image')
                            ->label('Featured Image')
                            ->disk('public')
                            ->image()
                            ->live()
                            ->directory('event/banner-image')
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
                                                        $desc = Str::limit($result['alt_description'] ?? 'Unsplash Image', 50);
                                                        $userName = $result['user']['name'];
                                                        $likes = number_format($result['likes'] ?? 0);

                                                        $attributionHtml = "
<div class='group flex items-center gap-4 p-3 rounded-lg transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50' style='width: 100%;'>
    <div class='relative flex-shrink-0' style='width: 96px; height: 96px;'>
        <img 
            src='{$thumb}' 
            alt='{$desc}'
            class='w-full h-full object-cover rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700 group-hover:ring-2 group-hover:ring-blue-400 transition-all'
            loading='lazy'
        />
        <div class='absolute inset-0 rounded-xl bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity'></div>
    </div>
    <div class='flex-1 min-w-0 space-y-1.5'>
        <h4 class='font-semibold text-sm text-gray-900 dark:text-gray-100 truncate leading-tight'>
            {$desc}
        </h4>
        <div class='flex items-center gap-2 text-xs'>
            <span class='text-gray-600 dark:text-gray-400'>
                by <span class='font-medium text-gray-700 dark:text-gray-300'>{$userName}</span>
            </span>
            <span class='text-gray-400 dark:text-gray-600'>•</span>
            <span class='inline-flex items-center gap-1 text-gray-500 dark:text-gray-400'>
                <svg class='w-3.5 h-3.5' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z' clip-rule='evenodd'/>
                </svg>
                {$likes}
            </span>
        </div>
        <div class='inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400'>
            <svg class='w-3 h-3' fill='currentColor' viewBox='0 0 20 20'>
                <path d='M10 12a2 2 0 100-4 2 2 0 000 4z'/>
                <path fill-rule='evenodd' d='M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z' clip-rule='evenodd'/>
            </svg>
            Unsplash
        </div>
    </div>
</div>";

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
                                            $set('banner_image', $imageData['url']);
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
                            ->viewData(function ($get, ?Event $record) {
                                $imageUrl = null;
                                $imageCredit = null;
                                $imageCreditUrl = null;
                                $isUnsplash = false;

                                $featuredImage = $get('banner_image');
                                $imageCredit = $get('image_credit');
                                $imageCreditUrl = $get('image_credit_url');
                                $unsplashPhotoId = $get('unsplash_photo_id');

                                if (empty($featuredImage) && $record) {
                                    $featuredImage = $record->banner_image;
                                    $imageCredit = $record->image_credit;
                                    $imageCreditUrl = $record->image_credit_url;
                                    $unsplashPhotoId = $record->unsplash_photo_id;
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
                            }),                    ]),

            ]);
    }

    public function render()
    {
        return view('livewire.events.table');
    }
}
