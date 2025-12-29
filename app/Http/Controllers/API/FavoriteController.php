<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display the authenticated user's favorite products.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->with(['category', 'images', 'user:id,first_name,last_name'])
            ->where('status', 'approved')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'discounted_price' => $product->discounted_price,
                    'discount_percentage' => $product->discount_percentage,
                    'images' => $product->getMedia('images')->count() > 0
                        ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                        : ($product->images?->pluck('image_url')->toArray() ?? []),
                    'category' => $product->category,
                    'seller' => [
                        'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                    ],
                    'is_favorited' => true, // Always true in favorites list
                ];
            });

        return response()->json([
            'data' => $favorites,
            'total' => $favorites->count(),
            'message' => 'Favorites retrieved successfully.',
        ]);
    }

    /**
     * Toggle a product in the user's favorites (add if not present, remove if present).
     */
    public function store(Product $product): JsonResponse
    {
        $user = Auth::user();

        // Check if product is approved
        if ($product->status !== 'approved') {
            return response()->json([
                'message' => 'Product not available.',
            ], 404);
        }

        // Check if already favorited
        $isFavorited = $user->favorites()->where('products.id', $product->id)->exists();

        if ($isFavorited) {
            // Remove from favorites
            $user->favorites()->detach($product->id);
            return response()->json([
                'message' => 'Product removed from favorites.',
                'is_favorited' => false,
            ]);
        } else {
            // Add to favorites
            $user->favorites()->attach($product->id);
            return response()->json([
                'message' => 'Product added to favorites.',
                'is_favorited' => true,
            ]);
        }
    }

    /**
     * Remove a product from the user's favorites.
     */
    public function destroy(Product $product): JsonResponse
    {
        $user = Auth::user();

        // Check if product is in favorites
        if (!$user->favorites()->where('products.id', $product->id)->exists()) {
            return response()->json([
                'message' => 'Product not in favorites.',
            ], 404);
        }

        $user->favorites()->detach($product->id);

        return response()->json([
            'message' => 'Product removed from favorites.',
            'is_favorited' => false,
        ]);
    }
}
