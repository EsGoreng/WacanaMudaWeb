<?php

namespace App\Services;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StoryGeneratorService
{
    /**
     * Generate Instagram Story Screenshot
     */
    public function generate(?Model $model, string $viewPath, string $dataKey = 'data'): ?StreamedResponse
    {

        if (! $model) {
            Notification::make()
                ->title('Generation Failed')
                ->body('Data content is not available.')
                ->danger()
                ->send();

            return null;
        }

        try {

            $html = view($viewPath, [
                $dataKey => $model,
            ])->render();

            $title = $model->title ?? 'story';
            $fileName = Str::slug($title).'-story.jpg';

            $screenshot = Browsershot::html($html)
                ->windowSize(1080, 1920)
                ->deviceScaleFactor(1)
                ->noSandbox()
                ->waitUntilNetworkIdle()
                ->screenshot();

            Notification::make()
                ->title('Story generated successfully')
                ->body('Your file is ready to download.')
                ->success()
                ->send();

            return response()->streamDownload(function () use ($screenshot) {
                echo $screenshot;
            }, $fileName);

        } catch (\Exception $e) {

            Notification::make()
                ->title('Generation Failed')
                ->body('An error occurred while creating the story image.')
                ->danger()
                ->persistent()
                ->send();

            Log::error('Story Generation Error: '.$e->getMessage());

            return null;
        }
    }
}
