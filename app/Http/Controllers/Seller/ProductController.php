<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = \Illuminate\Support\Facades\Auth::user()->products()->latest()->paginate(10);
        $categories = \App\Models\Category::all(); // Needed for the Add Product modal
        return view('seller.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'status' => 'nullable|string|in:approved,pending',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store in public disk under 'products' directory
                $path = $image->store('products', 'public');
                $imagePaths[] = $path; // Store relative path
            }
        }

        $product = \Illuminate\Support\Facades\Auth::user()->products()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'],
            'category_id' => $validated['category_id'],
            'status' => $request->has('status') ? 'approved' : 'pending',
            'images' => $imagePaths, // Assuming 'images' is cast to array in model
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Product $product)
    {
        // Ensure user owns the product
        if ($product->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('seller.products.create', compact('product', 'categories')); // Reusing create view for edit if structure is same, but better to have separate or shared
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        // Ensure user owns the product
        if ($product->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'status' => 'nullable|string|in:approved,pending',
        ]);

        $productData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'],
            'category_id' => $validated['category_id'],
            'status' => $request->has('status') ? 'approved' : 'pending',
        ];

        if ($request->hasFile('images')) {
            $imagePaths = $product->images; // Start with existing images if they are stored as array
            // If strictly replacing or appending depends on logic. Here I'll append.
            // Actually, for simplicity let's handle new uploads.
            // If the model creates ProductImage relations, this is different.
            // But Product model has 'images' attribute in fillable AND a hasMany 'images' relationship.
            // Let's check the Product model again to be sure about 'images' column usage.

            // Re-checking model: CAST 'images' => 'array'. So it uses a JSON column.

            $currentImages = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $currentImages[] = $path;
            }
            $productData['images'] = $currentImages;
        }

        $product->update($productData);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Product $product)
    {
        if ($product->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully!');
    }
}
