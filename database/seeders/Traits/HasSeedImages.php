<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait HasSeedImages
{
    /**
     * Download image from URL and return local path.
     * Caches image in storage/app/seed_images
     */
    protected function getLocalImage(string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Create directory if not exists
        $directory = storage_path('app/seed_images');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Generate filename from URL (or hash it to avoid weird chars)
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!$extension) {
            $extension = 'jpg'; // Default to jpg if no extension found
        }

        // Use MD5 of URL to ensure unique filename for each URL
        $filename = md5($url) . '.' . $extension;
        $path = $directory . '/' . $filename;

        // Return path if already exists
        if (File::exists($path)) {
            return $path;
        }

        // Download
        try {
            $response = Http::timeout(30)->withoutVerifying()->get($url);

            if ($response->successful()) {
                File::put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            // Log error or just return null
            echo "Failed to download: $url - " . $e->getMessage() . "\n";
        }

        return null;
    }
}
