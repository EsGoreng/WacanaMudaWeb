<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Card extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public User $user;

    public function toggleFollow()
    {
        $currentUser = Auth::user();

        if (! $currentUser || $currentUser->id === $this->user->id) {
            return;
        }

        if ($this->user->isFollowedBy($currentUser)) {

            $currentUser->followings()->detach($this->user->id);

            $this->user->decrement('followers_count');
            $currentUser->decrement('following_count');
        } else {

            $currentUser->followings()->attach($this->user->id);

            $this->user->increment('followers_count');
            $currentUser->increment('following_count');
        }

        $this->user->refresh();

        Notification::make()
            ->title($this->user->isFollowedBy($currentUser) ? 'Followed' : 'Unfollowed')
            ->success()
            ->send();
    }

    public function editProfile(): Action
    {
        return Action::make('editProfile')
            ->label('Edit')
            ->icon('heroicon-m-pencil-square')
            ->color('gray')
            ->fillForm(fn (): array => [
                'name' => $this->user->name,
                'username' => $this->user->username,
                'bio' => $this->user->bio,
                'avatar' => $this->user->avatar,
                'phone' => $this->user->phone,
                'instagram_url' => $this->user->instagram_url,
                'linkedin_url' => $this->user->linkedin_url,
            ])
            ->form([
                Grid::make(3)
                    ->schema([
                        FileUpload::make('avatar')
                            ->image()
                            ->avatar()
                            ->maxSize(2048)
                            ->optimize('webp')
                            ->resize(50)
                            ->disk('public')
                            ->directory('avatars')
                            ->imageEditor()
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('username')
                            ->required()
                            ->maxLength(255)
                            ->rules([
                                Rule::unique('users', 'username')->ignore($this->user->id),
                            ]),

                        TextInput::make('phone')
                            ->tel()
                            ->label('Phone Number'),

                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->placeholder('https://instagram.com/...')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->placeholder('https://linkedin.com/in/...')
                            ->url()
                            ->maxLength(255),

                        MarkdownEditor::make('bio')
                            ->label('Bio')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                            ])
                            ->columnSpanFull(),
                    ]),
            ])
            ->action(function (array $data): void {
                if (isset($data['avatar']) && $this->user->avatar && $data['avatar'] !== $this->user->avatar) {
                    Storage::disk('public')->delete($this->user->avatar);
                }

                $this->user->update($data);

                $this->user->refresh();

                Notification::make()
                    ->title('Profile updated successfully')
                    ->success()
                    ->send();
            })
            ->extraAttributes([
                'class' => 'bg-zinc-100 text-zinc-900 border border-zinc-200 hover:bg-zinc-200 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-600 rounded-xl px-3 py-1 text-xs',
            ]);
    }

    public function render()
    {
        return view('livewire.profile.card');
    }
}
