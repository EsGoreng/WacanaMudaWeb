<?php

namespace App\Services;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class StoryGeneratorService
{
    /**
     * Generate Instagram Story Screenshot
     */
    public function generate(?Model $model, string $viewPath, string $dataKey = 'data'): ?string
    {
        if (! $model) {
            Notification::make()
                ->title('Failed')
                ->body('Data not found.')
                ->danger()
                ->send();

            return null;
        }

        try {
            return view($viewPath, [
                $dataKey => $model,
            ])->render();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed processing Story')
                ->body('There\'s something wrong.')
                ->danger()
                ->persistent()
                ->send();

            Log::error('Story Preparation Error: '.$e->getMessage());

            return null;
        }
    }
}
