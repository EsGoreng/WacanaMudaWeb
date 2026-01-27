<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Services\BookmarkService;
use App\Traits\InteractsWithEventModal;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithEventModal;
    use InteractsWithForms;

    public User $user;

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'p'],
    ];

    public function editProfile(): Action
    {
        return Action::make('editProfile')
            ->label('Edit Profile')
            ->icon('heroicon-m-pencil-square')
            ->color('gray')
            ->fillForm(fn (): array => [
                'name' => $this->user->name,
                'username' => $this->user->username,
                'bio' => $this->user->bio,
                'avatar' => $this->user->avatar,
                'phone' => $this->user->phone,
            ])
            ->form([
                FileUpload::make('avatar')
                    ->image()
                    ->avatar()
                    ->disk('public')
                    ->directory('avatars')
                    ->imageEditor(),

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

                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),
            ])
            ->action(function (array $data): void {
                if (isset($data['avatar']) && $this->user->avatar && $data['avatar'] !== $this->user->avatar) {
                    Storage::disk('public')->delete($this->user->avatar);
                }

                $this->user->update($data);

                Notification::make()
                    ->title('Profile updated successfully')
                    ->success()
                    ->send();
            })
            ->extraAttributes([
                'class' => 'bg-zinc-100 text-zinc-900 border border-zinc-200 hover:bg-zinc-200 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-600 rounded-xl px-4 py-2',
            ]);
    }

    public function mount(?User $user = null)
    {
        $this->user = $user->exists ? $user : Auth::user();
    }

    public function render(BookmarkService $bookmarkService)
    {
        return view('livewire.profile.show', [
            'user' => $this->user,
            'writings' => $this->user->writings()
                ->latest()
                ->when(Auth::id() !== $this->user->id, function ($query) {
                    $query->where('status', 'published')
                        ->where('is_anonymous', false);
                })
                ->paginate(3),
            'forums' => $this->user->forums()
                ->latest()
                ->withCount('comments')
                ->paginate(3),
        ]);
    }
}
