<?php

namespace App\Livewire\Forums;

use App\Livewire\BaseDataTable;
use App\Models\Forum;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;

class Table extends BaseDataTable
{
    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->query(Forum::query()->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('category.name')
                    ->badge()
                    ->color(fn ($record) => match ($record->category->name) {
                        'Technology' => 'info',
                        'Business' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('comments_count')
                    ->counts('comments')
                    ->label('Komentar')
                    ->badge(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),

                $this->getDeleteAction()
                    ->successNotificationTitle('Forum topic deleted'),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->bulkActions([
                $this->getBulkDeleteAction(),
            ]);
    }

    public function render()
    {
        return view('livewire.forums.table');
    }
}
