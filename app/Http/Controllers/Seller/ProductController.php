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
            'images' => 'nullable|array|max:5',
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
            'status' => 'pending',
            // 'images' is not a column in products table, handled below
        ]);

        if (!empty($imagePaths)) {
            foreach ($imagePaths as $path) {
                // Determine full URL or relative path. 
                // ProductImage model has 'image_url'. API uses full URL often, but local storage returns relative path.
                // View uses Storage::url($img).
                // Let's store the relative path or full URL. The API controller passed full URL.
                // But here we are uploading locally.
                // Let's store the path returned by store(), which is relative to disk root.
                // Wait, if API expects URL, we might need to convert it?
                // Actually, API Controller `store` took `images.*` as string/url.
                // View `create.blade.php` uses `Storage::url($img)`.
                // So if we store "products/filename.jpg", Storage::url() will work.

                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Product $product)
    {
        return view('seller.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Product $product)
    {
        // Ensure user owns the product
        // if ($product->user_id != \Illuminate\Support\Facades\Auth::id()) {
        //     abort(403);
        // }

        $categories = \App\Models\Category::all();
        return view('seller.products.create', compact('product', 'categories')); // Reusing create view for edit if structure is same, but better to have separate or shared
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        // Ensure user owns the product
        // if ($product->user_id != \Illuminate\Support\Facades\Auth::id()) {
        //     abort(403);
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'string',
            'status' => 'nullable|string|in:approved,pending,active',
        ]);

        $productData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'],
            'category_id' => $validated['category_id'],
            'status' => $request->status ? 'approved' : 'pending',
        ];

        // Handle Images Update

        // 1. Get images kept by user (from hidden inputs - these are paths)
        $keptImages = $request->input('existing_images', []);

        // 2. Delete images that are NOT in keptImages
        // Get current images from DB
        $currentImages = $product->images; // Collection of ProductImage models
        foreach ($currentImages as $imgModel) {
            if (!in_array($imgModel->image_url, $keptImages)) {
                // Delete file from storage
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imgModel->image_url)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($imgModel->image_url);
                }
                // Delete record
                $imgModel->delete();
            }
        }

        // 3. Upload new images and create records
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);
            }
        }

        $product->update($productData);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Product $product)
    {
        // if ($product->user_id != \Illuminate\Support\Facades\Auth::id()) {
        //     abort(403);
        // }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully!');
    }
}
