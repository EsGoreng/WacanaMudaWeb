<?php

namespace App\Actions\Writing;

use App\Models\Writing;
use App\Services\UnsplashService;

class UpsertWriting
{
    public ?Writing $writing = null;

    public function execute(array $data, ?Writing $writing = null): Writing
    {
        $categoryIds = $data['categories'] ?? [];
        unset($data['categories']);

        if (empty($data['featured_image']) && ! empty($data['unsplash_photo_id'])) {
            if ($writing && $writing->unsplash_photo_id === $data['unsplash_photo_id']) {
                $data['featured_image'] = $writing->featured_image;
            }
        }

        if (($data['status'] ?? 'draft') === 'Published' && empty($data['published_at'])) {
            if (! $writing || $writing->status !== 'Published') {
                $data['published_at'] = now();

                if (! empty($data['unsplash_download_location'])) {
                    (new UnsplashService)->triggerUnsplashDownload($this->writing->unsplash_download_location);
                }
            }
        }

        if (! empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['reading_time'] = max(1, ceil($wordCount / 200));
        }

        if ($writing) {
            $writing->update($data);
        } else {
            $data['user_id'] = $data['user_id'] ?? auth()->id();
            $writing = Writing::create($data);
        }

        $writing->categories()->sync($categoryIds);

        return $writing;
    }
}
