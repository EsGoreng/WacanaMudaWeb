<?php

namespace App\Livewire;

use App\Models\Writing;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class WritingTable extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->heading('Manage Writings')
            ->description('This table allows you to manage all of your created writings efficiently.')
            ->query(Writing::query()->with(['user', 'category', 'series']))
            ->defaultSort('writing_id', 'desc')
            ->columns([
                TextColumn::make('writing_id')
                    ->label('ID')
                    ->formatStateUsing(fn ($state) => '#'.str_pad($state, 4, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->hidden()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->description(fn (Writing $record) => Str::limit(strip_tags($record->content), 60))
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label('Writer')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Writing $record) => $record->is_anonymous ? 'Anonymous' : ($record->user->name ?? 'Unknown'))
                    ->badge()
                    ->color(fn (Writing $record) => $record->is_anonymous ? 'gray' : 'primary')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('series.name')
                    ->label('Series')
                    ->badge()
                    ->color('info')
                    ->default('-')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('reading_time')
                    ->label('Reading Time')
                    ->formatStateUsing(fn ($state) => $state ? $state.' menit' : '-')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'danger',
                        default => 'gray',
                    })
                    ->alignCenter()
                    ->toggleable(),

                ToggleColumn::make('is_anonymous')
                    ->label('Anonim')
                    ->onColor('success')
                    ->offColor('gray')
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label('Published At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),

                SelectFilter::make('series_id')
                    ->label('Series')
                    ->relationship('series', 'name'),

                TernaryFilter::make('is_anonymous')
                    ->label('Anonym'),

                Filter::make('published_at')
                    ->schema([
                        DateTimePicker::make('dari_tanggal')
                            ->label('From'),
                        DateTimePicker::make('sampai_tanggal')
                            ->label('To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date) => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date) => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->color('success')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Article Detail')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('7xl')
                    ->schema(fn (Schema $schema) => $this->getWritingSchema($schema))
                    ->mountUsing(function (Schema $schema, Writing $record) {
                        $schema->fill($record->toArray());
                    })
                    ->disabledSchema(),

                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Writing $record) => route('dashboard.writing.edit', $record)),

                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Writing $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Article deleted successfully')
                            ->danger()
                            ->send();
                    }),
            ])
            ->headerActions([
                Action::make('add')
                    ->label('Write Something')
                    ->icon('heroicon-o-pencil')
                    ->color('primary')
                    ->url(route('dashboard.writing.create')),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->label('Delete Selected')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        DB::transaction(function () use ($records) {
                            foreach ($records as $record) {
                                $record->delete();
                            }
                        });

                        Notification::make()
                            ->title('Article deleted Successfully')
                            ->body(count($records).' artiicle already deleted.')
                            ->danger()
                            ->send();
                    }),
            ]);
    }

    protected function getWritingSchema(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Article Information')
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
                            ->unique(Writing::class, 'slug', ignoreRecord: true)
                            ->columnSpanFull(),

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required()->maxLength(255),
                                TextInput::make('slug')->required()->maxLength(255),
                                Textarea::make('description')->rows(3),
                            ]),

                        Select::make('series_id')
                            ->label('Series')
                            ->relationship('series', 'name', fn (Builder $query) => $query->where('user_id', auth()->id()))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required()->maxLength(255),
                                Textarea::make('description')->rows(3),
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
                            ->label('Publicaton Date'),

                        TextInput::make('reading_time')
                            ->label('Reading Time')
                            ->numeric()
                            ->helperText('(±200 word/minute)')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),

                Section::make('Article Content')
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
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function render()
    {
        return view('livewire.writing-table');
    }
}
