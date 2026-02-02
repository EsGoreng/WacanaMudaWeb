<?php

namespace App\Livewire\Forums;

use App\Livewire\BaseDataTable;
use App\Models\Category;
use App\Models\Forum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Support\Str;

class Table extends BaseDataTable implements HasActions
{
    use InteractsWithActions;

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
                    ->icon('heroicon-o-pencil')
                    ->mountUsing(function ($form, Forum $record) {
                        $form->fill([
                            'title' => $record->title,
                            'slug' => $record->slug,
                            'body' => $record->body,
                            'is_anonymous' => $record->is_anonymous,
                            'categories' => $record->categories->pluck('category_id')->toArray(),
                        ]);
                    })
                    ->form([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Hidden::make('slug'),
                        Select::make('categories')
                            ->label('Categories')
                            ->options(Category::all()->pluck('name', 'category_id'))
                            ->multiple()
                            ->maxItems(3)
                            ->preload()
                            ->searchable()
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
                            ->columnSpanFull(),
                    ])
                    ->action(function (Forum $record, array $data) {
                        $categoryIds = $data['categories'] ?? [];
                        unset($data['categories']);

                        $record->update($data);

                        $record->categories()->sync($categoryIds);

                        Notification::make()
                            ->title('Forum updated successfully')
                            ->success()
                            ->send();
                    }),

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
