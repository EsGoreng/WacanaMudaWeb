<?php

namespace App\Livewire\Members;

use App\Livewire\BaseDataTable;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table as FilamentTable;

class Table extends BaseDataTable
{
    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->query(User::query()->where('id', '!=', auth()->id()))
            ->heading('Manage Members')
            ->description('Manage registered users in the platform.')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (User $record) => $record->email),

                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Role')
                    ->separator(',')
                    ->color(fn ($state) => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'warning',
                        default => 'info',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Joined'),
            ])
            ->filters([
            ])
            ->recordActions([
                Action::make('edit')
                    ->mountUsing(function ($form, User $record) {
                        $form->fill([
                            'name' => $record->name,
                            'email' => $record->email,
                            'phone' => $record->phone,
                            'roles' => $record->roles->pluck('id')->toArray(),
                        ]);
                    })
                    ->action(function (User $record, array $data) {
                        $record->update([
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'phone' => $data['phone'] ?? $record->phone,
                        ]);

                        if (isset($data['roles'])) {
                            $record->roles()->sync($data['roles']);
                        }

                        Notification::make()
                            ->title('Member updated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->email()->required(),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload(),
                    ]),

                $this->getDeleteAction()
                    ->successNotificationTitle('Forum topic deleted'),
            ]);
    }

    public function render()
    {
        return view('livewire.members.table');
    }
}
