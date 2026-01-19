<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the authenticated user's addresses.
     */
    public function index(): JsonResponse
    {
        $addresses = Address::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $addresses,
            'message' => 'Addresses retrieved successfully.',
        ]);
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'description' => 'nullable|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        // If setting as default, unset other defaults
        if ($validated['is_default'] ?? false) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        $address = Address::create($validated);

        return response()->json([
            'data' => $address,
            'message' => 'Address created successfully.',
        ], 201);
    }

    /**
     * Display the specified address.
     */
    public function show(Address $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        return response()->json([
            'data' => $address,
            'message' => 'Address retrieved successfully.',
        ]);
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'string|max:100',
            'full_address' => 'string|max:500',
            'description' => 'nullable|string|max:500',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        if (isset($validated['is_default']) && $validated['is_default']) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return response()->json([
            'data' => $address,
            'message' => 'Address updated successfully.',
        ]);
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $address->delete();

        return response()->json([
            'message' => 'Address deleted successfully.',
        ]);
    }

    /**
     * Set the specified address as default.
     */
    public function setDefault(Address $address): JsonResponse
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        Address::where('user_id', Auth::id())
            ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return response()->json([
            'data' => $address,
            'message' => 'Default address updated successfully.',
        ]);
    }
}
