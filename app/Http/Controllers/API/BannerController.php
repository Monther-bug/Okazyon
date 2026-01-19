<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Get the active banner for the home page.
     * Public endpoint - returns the first active banner.
     */
    public function index(): JsonResponse
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($banners->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No active banner found.',
            ]);
        }

        $data = $banners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'image_url' => $banner->image,
                'link' => $banner->link,
                'is_active' => $banner->is_active,
                'created_at' => $banner->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'message' => 'Active banners retrieved successfully.',
        ]);
    }
}
