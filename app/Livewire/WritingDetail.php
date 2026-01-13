<?php

namespace App\Livewire;

use App\Models\Writing;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class WritingDetail extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public Writing $writing;

    public function mount(Writing $writing)
    {
        $this->writing = $writing;

        if ($this->writing->status !== 'published' && $this->writing->status !== 'Published') {
            abort(404);
        }
    }

    public function articleInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->writing)
            ->components([
                TextEntry::make('content')
                    ->hiddenLabel()
                    ->html()
                    ->prose()
                    ->columnSpanFull(),
            ]);
    }

    public function render()
    {
        $latestPosts = Writing::with('user')
            ->where('status', 'published')
            ->where('writing_id', '!=', $this->writing->writing_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.writing-detail', [
            'latestPosts' => $latestPosts,
        ])->layoutData([
            'title' => $this->writing->title.' | WMB',
            'contentClass' => '!p-0 !max-w-none min-h-screen',
        ]);
    }
}
