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
        $user = auth()->user();

        return $table
            ->striped()
            ->heading('Manage Forums')
            ->description('This table allows you to manage all of your created forums efficiently.')
            ->query(Forum::query()
                ->when(
                    ! $user->hasRole('superadmin'),
                    fn ($query) => $query->where('user_id', $user->id)
                )
            )
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                    ->separator(',')
                    ->limitList(2)
                    ->color('info'),

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
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
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
