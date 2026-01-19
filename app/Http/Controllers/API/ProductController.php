<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Public endpoint - only shows approved products.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['user', 'category', 'images'])->where('status', 'approved');

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->get();

        // Get user's favorites if authenticated
        $userFavorites = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->allRelatedIds()->toArray();
        }

        // Transform products with is_favorited attribute
        $transformedProducts = $products->map(function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'images' => $product->images ? $product->images->pluck('image_url') : [],
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json([
            'data' => $transformedProducts,
            'message' => 'Products retrieved successfully.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Protected endpoint - requires authentication.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:price',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string|url',
            'expiration_date' => 'nullable|date|after:today',
            'storage_instructions' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        // Remove images from validated data before creating product
        $images = $validated['images'] ?? [];
        unset($validated['images']);

        $product = Product::create($validated);

        // Create product images if provided
        if (!empty($images)) {
            foreach ($images as $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                ]);
            }
        }

        $product->load(['user', 'category', 'images']);

        return response()->json([
            'data' => $product,
            'message' => 'Product created successfully.',
        ], 201);
    }

    /**
     * Get fresh deals (food/grocery items).
     * Public endpoint with pagination.
     */
    public function freshDeals(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->allRelatedIds()->toArray();
        }

        $products = Product::with(['user', 'category', 'images'])
            ->approved()
            ->whereHas('category', function ($query) {
                // Assuming 'food' is the type for fresh/grocery
                // Verify with migration: 2025_09_28_171901_add_image_url_and_type_to_categories_table.php (default 'food')
                // Types might be 'food', 'standard', etc.
                // Requirement: "Fresh" or "Groceries" categories.
                $query->where('type', 'food');
            })
            ->latest()
            ->paginate(20);

        // Transform products
        $transformedProducts = $products->getCollection()->map(function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'images' => $product->images ? $product->images->pluck('image_url') : [],
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json([
            'data' => $transformedProducts,
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'message' => 'Fresh deals retrieved successfully.',
        ]);
    }

    /**
     * Get store finds (apparel, goods, non-food).
     * Public endpoint with pagination.
     */
    public function storeFinds(Request $request): JsonResponse
    {
        // Get user's favorites if authenticated
        $userFavorites = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorites()->allRelatedIds()->toArray();
        }

        $products = Product::with(['user', 'category', 'images'])
            ->approved()
            ->whereHas('category', function ($query) {
                // Requirement: "Apparel", "Clothing", etc.
                // Basically anything NOT 'food'.
                $query->where('type', '!=', 'food');
            })
            ->latest()
            ->paginate(20);

        // Transform products
        $transformedProducts = $products->getCollection()->map(function ($product) use ($userFavorites) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'discount_percentage' => $product->discount_percentage,
                'status' => $product->status,
                'images' => $product->images ? $product->images->pluck('image_url') : [],
                'category' => $product->category,
                'seller' => [
                    'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
                ],
                'is_favorited' => in_array($product->id, $userFavorites),
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json([
            'data' => $transformedProducts,
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'message' => 'Store finds retrieved successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     * Public endpoint - only shows approved products.
     */
    public function show(Product $product): JsonResponse
    {
        // Only show approved products to public
        if ($product->status !== 'approved') {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        // Eager load basic relationships
        $product->load(['images', 'category', 'user:id,first_name,last_name,is_verified']);

        // Prepare seller information
        $seller = [
            'id' => $product->user->id,
            'name' => trim($product->user->first_name . ' ' . $product->user->last_name),
            'is_verified' => $product->user->is_verified ?? false,
        ];

        // Initialize review data
        $reviewData = [
            'reviews' => [],
            'average_rating' => 0,
            'total_reviews_count' => 0
        ];

        // Only include reviews for non-food products
        if ($product->category && $product->category->type !== 'food') {
            $product->load([
                'reviews' => function ($query) {
                    $query->with('user:id,first_name,last_name')->orderBy('created_at', 'desc');
                }
            ]);

            if ($product->reviews->count() > 0) {
                $reviewData = [
                    'reviews' => $product->reviews->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'rating' => $review->rating,
                            'comment' => $review->comment,
                            'user' => [
                                'name' => trim($review->user->first_name . ' ' . $review->user->last_name),
                            ],
                            'created_at' => $review->created_at->diffForHumans(),
                        ];
                    }),
                    'average_rating' => round($product->reviews->avg('rating'), 1),
                    'total_reviews_count' => $product->reviews->count()
                ];
            }
        }

        // Check if product is favorited by authenticated user
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->favorites()->where('product_id', $product->id)->exists();
        }

        // Prepare the complete response
        $response = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'discounted_price' => $product->discounted_price,
            'discount_percentage' => $product->discount_percentage,
            'status' => $product->status,
            'expiration_date' => $product->expiration_date,
            'storage_instructions' => $product->storage_instructions,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'images' => $product->images ? $product->images->pluck('image_url') : [],
            'category' => $product->category,
            'seller' => $seller,
            'is_favorited' => $isFavorited,
        ];

        // Merge review data
        $response = array_merge($response, $reviewData);

        return response()->json([
            'data' => $response,
            'message' => 'Product retrieved successfully.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Protected endpoint - requires authentication and ownership.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        // Check if the authenticated user owns this product
        if ($product->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized. You can only update your own products.',
            ], 403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:price',
            'image_url' => 'nullable|string|url',
            'status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected', 'sold'])],
            'expiration_date' => 'nullable|date|after:today',
            'storage_instructions' => 'nullable|string',
        ]);

        $product->update($validated);
        $product->load(['user', 'category']);

        return response()->json([
            'data' => $product,
            'message' => 'Product updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * Protected endpoint - requires authentication and ownership.
     */
    public function destroy(Product $product): JsonResponse
    {
        // Check if the authenticated user owns this product
        if ($product->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete your own products.',
            ], 403);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
