<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get the authenticated user's cart.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart ?? $user->cart()->create();

        return response()->json([
            'data' => $this->transformCart($cart),
            'message' => 'Cart retrieved successfully.'
        ]);
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = $request->user();
        $cart = $user->cart ?? $user->cart()->create();

        // Check if item already exists
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create new item
            $cartItem = $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'data' => $this->transformCart($cart->refresh()),
            'message' => 'Item added to cart successfully.'
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, \App\Models\CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Ensure user owns this cart item
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'data' => $this->transformCartItem($cartItem),
            'message' => 'Cart item updated.'
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Request $request, \App\Models\CartItem $cartItem)
    {
        // Ensure user owns this cart item
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Item removed from cart.'
        ]);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(Request $request)
    {
        $user = $request->user();
        if ($user->cart) {
            $user->cart->items()->delete();
        }

        return response()->json([
            'message' => 'Cart cleared successfully.'
        ]);
    }

    /**
     * Transform the cart model.
     */
    private function transformCart($cart)
    {
        // Load relationships needed for transformation
        $cart->load(['items.product.user', 'items.product.category', 'items.product.images']);

        return [
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'items' => $cart->items->map(function ($item) {
                return $this->transformCartItem($item);
            }),
            'created_at' => $cart->created_at,
            'updated_at' => $cart->updated_at,
        ];
    }

    /**
     * Transform a single cart item.
     */
    private function transformCartItem($item)
    {
        // Ensure product relationships are loaded if not already
        if (!$item->relationLoaded('product')) {
            $item->load(['product.user', 'product.category', 'product.images']);
        }

        $product = $item->product;

        // Transform product to match what Flutter expects (similar to ProductController)
        $transformedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'discounted_price' => $product->discounted_price,
            'discount_percentage' => $product->discount_percentage,
            'status' => $product->status,
            'is_featured' => $product->is_featured,
            'images' => $product->images ? $product->images->pluck('image_url') : [],
            'category' => $product->category,
            'seller' => [
                'name' => trim(($product->user->first_name ?? '') . ' ' . ($product->user->last_name ?? '')),
            ],
            'is_favorited' => false, // Default false in cart context
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];

        return [
            'id' => $item->id,
            'cart_id' => $item->cart_id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'product' => $transformedProduct,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
