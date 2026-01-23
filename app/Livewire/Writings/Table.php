<?php

namespace App\Livewire\Writings;

use App\Livewire\BaseDataTable;
use App\Models\Writing;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Table extends BaseDataTable
{
    public function table(FilamentTable $table): FilamentTable
    {
        $user = auth()->user();

        return $table
            ->striped()
            ->heading('Manage Writings')
            ->description('This table allows you to manage all of your created writings efficiently.')
            ->query(Writing::query()
                ->when(
                    ! $user->hasRole('superadmin'),
                    fn ($query) => $query->where('user_id', $user->id)
                )
                ->with(['user', 'categories', 'series']))
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

                TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                    ->separator(',')
                    ->searchable()
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
                        'Published' => 'success',
                        'Draft' => 'warning',
                        'Archived' => 'danger',
                        default => 'gray',
                    })
                    ->alignCenter()
                    ->toggleable(),

                ToggleColumn::make('is_anonymous')
                    ->label('Anonim')
                    ->onColor('success')
                    ->offColor('gray')
                    ->hidden()
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
                        'Draft' => 'Draft',
                        'Published' => 'Published',
                        'Archived' => 'Archived',
                    ]),

                SelectFilter::make('categories')
                    ->label('Categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),

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
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Writing $record) => route('dashboard.writing.edit', $record)),

                $this->getDeleteAction()
                    ->successNotificationTitle('Article deleted successfully'),
            ])
            ->headerActions([
                Action::make('add')
                    ->label('Write Something')
                    ->icon('heroicon-o-pencil')
                    ->url(route('dashboard.writing.create')),
            ])
            ->bulkActions([
                $this->getBulkDeleteAction(),
            ]);
    }

    public function render()
    {
        return view('livewire.writings.table');
    }
}
