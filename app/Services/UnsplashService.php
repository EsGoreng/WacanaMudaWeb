<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UnsplashService
{
    public function triggerUnsplashDownload(string $downloadLocation): void
    {
        try {
            Http::withOptions([
                'verify' => false,
                'connect_timeout' => 10,
                'timeout' => 10,
                'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4],
            ])->get($downloadLocation, [
                'client_id' => env('UNSPLASH_ACCESS_KEY'),
            ]);
        } catch (\Exception $e) {
            \Log::warning('Failed to trigger Unsplash download: '.$e->getMessage());
        }
    }
}
