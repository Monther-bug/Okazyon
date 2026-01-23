<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class HomeController extends Controller
{
    /**
     * Get curated product lists for the home page.
     * Public endpoint - returns featured deals, new deals, and other curated content.
     */
    public function index(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated (handling optional auth manually)
        $userFavorites = [];
        if ($user = $this->getAuthenticatedUser($request)) {
            $userFavorites = $user->favorites()->allRelatedIds()->toArray();
        }



        // Helper function to transform products consistently
        $transformProduct = function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'is_featured' => $product->is_featured,
                'images' => $product->getMedia('images')->count() > 0
                    ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                    : ($product->images?->pluck('image_url')->toArray() ?? []),
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        };

        // 1. Featured Deals - Products marked as featured (limited to 10 for home page)
        $featuredDeals = Product::with(['user', 'category', 'images'])
            ->approved()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map($transformProduct);

        // 2. New Deals - Recently added products (limited to 10 for home page)
        $newDeals = Product::with(['user', 'category', 'images'])
            ->approved()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map($transformProduct);

        // 3. Best Discounts - Products with highest discount percentages (limited to 10)
        $bestDiscounts = Product::with(['user', 'category', 'images'])
            ->approved()
            ->whereNotNull('discounted_price')
            ->where('discounted_price', '>', 0)
            ->get()
            ->sortByDesc('discount_percentage')
            ->take(10)
            ->values()
            ->map($transformProduct);

        // 4. Category Highlights - Popular products from different categories (limited to 8)
        $categoryHighlights = Product::with(['user', 'category', 'images'])
            ->approved()
            ->inRandomOrder()
            ->limit(8)
            ->get()
            ->map($transformProduct);

        return response()->json([
            'data' => [
                'featured_deals' => [
                    'title' => 'منتجات مميزة',
                    'products' => $featuredDeals,
                    'total' => $featuredDeals->count(),
                ],
                'new_deals' => [
                    'title' => 'وصل حديثا',
                    'products' => $newDeals,
                    'total' => $newDeals->count(),
                ],
                'best_discounts' => [
                    'title' => 'أفضل الخصومات',
                    'products' => $bestDiscounts,
                    'total' => $bestDiscounts->count(),
                ],
                'category_highlights' => [
                    'title' => 'الأكثر تداولا',
                    'products' => $categoryHighlights,
                    'total' => $categoryHighlights->count(),
                ],
            ],
            'message' => 'Home page data retrieved successfully.',
        ]);
    }

    /**
     * Get all featured deals for "View All" page.
     * Public endpoint with pagination.
     */
    public function featuredDeals(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if ($user = $this->getAuthenticatedUser($request)) {
            $userFavorites = $user->favorites()->allRelatedIds()->toArray();
        }

        // Helper function to transform products consistently
        $transformProduct = function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'is_featured' => $product->is_featured,
                'images' => $product->getMedia('images')->count() > 0
                    ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                    : ($product->images?->pluck('image_url')->toArray() ?? []),
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        };

        // Get ALL featured products with pagination
        $featuredProducts = Product::with(['user', 'category', 'images'])
            ->approved()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Transform products
        $transformedProducts = $featuredProducts->getCollection()->map($transformProduct);

        return response()->json([
            'data' => $transformedProducts,
            'total' => $featuredProducts->total(),
            'per_page' => $featuredProducts->perPage(),
            'current_page' => $featuredProducts->currentPage(),
            'last_page' => $featuredProducts->lastPage(),
            'message' => 'Featured deals retrieved successfully.',
        ]);
    }

    /**
     * Get all new deals for "View All" page.
     * Public endpoint with pagination.
     */
    public function newDeals(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if ($user = $this->getAuthenticatedUser($request)) {
            $userFavorites = $user->favorites()->allRelatedIds()->toArray();
        }

        // Helper function to transform products consistently
        $transformProduct = function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'is_featured' => $product->is_featured,
                'images' => $product->getMedia('images')->count() > 0
                    ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                    : ($product->images?->pluck('image_url')->toArray() ?? []),
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        };

        // Get ALL new products with pagination
        $newProducts = Product::with(['user', 'category', 'images'])
            ->approved()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Transform products
        $transformedProducts = $newProducts->getCollection()->map($transformProduct);

        return response()->json([
            'data' => $transformedProducts,
            'total' => $newProducts->total(),
            'per_page' => $newProducts->perPage(),
            'current_page' => $newProducts->currentPage(),
            'last_page' => $newProducts->lastPage(),
            'message' => 'New deals retrieved successfully.',
        ]);
    }

    /**
     * Get all best discounts for "View All" page.
     * Public endpoint with pagination.
     */
    public function bestDiscounts(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if ($user = $this->getAuthenticatedUser($request)) {
            $userFavorites = $user->favorites()->allRelatedIds()->toArray();
        }

        // Helper function to transform products consistently
        $transformProduct = function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'is_featured' => $product->is_featured,
                'images' => $product->getMedia('images')->count() > 0
                    ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                    : ($product->images?->pluck('image_url')->toArray() ?? []),
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        };

        // Note: Sort by calculated discount_percentage is hard in SQL directly without subquery or stored generated column.
        // For efficiency in this "View All" endpoint, we'll sort by the raw difference if possible, or just fetch and sort.
        // However, pagination breaks if we fetch all.
        // A common approximation is sorting by (price - discounted_price) or just using the boolean check and then sorting by created_at.
        // But the requirement implies "Best Discounts".
        // Let's try to order by the raw discount amount (price - discounted_price) which is closish, or valid.
        // Actually, if we want true percentage sort with pagination, we need a raw DB expression.

        $products = Product::with(['user', 'category', 'images'])
            ->approved()
            ->whereNotNull('discounted_price')
            ->where('discounted_price', '>', 0)
            ->selectRaw('*, (price - discounted_price) / price * 100 as calculated_discount')
            ->orderByDesc('calculated_discount')
            ->paginate(20);

        // Transform products
        $transformedProducts = $products->getCollection()->map($transformProduct);

        return response()->json([
            'data' => $transformedProducts,
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'message' => 'Best discounts retrieved successfully.',
        ]);
    }

    /**
     * Get all category highlights for "View All" page.
     * Public endpoint with pagination.
     */
    public function categoryHighlights(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if ($user = $this->getAuthenticatedUser($request)) {
            $userFavorites = $user->favorites()->allRelatedIds()->toArray();
        }

        // Helper function to transform products consistently
        $transformProduct = function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'is_featured' => $product->is_featured,
                'images' => $product->getMedia('images')->count() > 0
                    ? $product->getMedia('images')->map(fn($media) => $media->getUrl())->toArray()
                    : ($product->images?->pluck('image_url')->toArray() ?? []),
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        };

        // For "View All", we shouldn't use random order as it messes up pagination.
        // We will use latest products from diverse categories or just latest approved.
        // The implementation_plan said "stable ordering".
        $products = Product::with(['user', 'category', 'images'])
            ->approved()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Transform products
        $transformedProducts = $products->getCollection()->map($transformProduct);

        return response()->json([
            'data' => $transformedProducts,
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'message' => 'Category highlights retrieved successfully.',
        ]);
    }
    /**
     * Helper to manually authenticate user from request token.
     */
    private function getAuthenticatedUser(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($token);

            \Illuminate\Support\Facades\Log::info('Home Auth Debug', [
                'token' => $token,
                'accessToken_found' => (bool) $accessToken,
                'user' => $accessToken?->tokenable?->id
            ]);

            if ($accessToken && $accessToken->tokenable) {
                return $accessToken->tokenable;
            }
        }
        return null;
    }
}
