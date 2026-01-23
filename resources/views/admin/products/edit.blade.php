<x-layouts.admin-dashboard>
    <x-slot:title>Review Product</x-slot>
        <x-slot:header>Review Product: {{ $product->name }}</x-slot>

            <div class="max-w-4xl mx-auto space-y-6">

                <!-- Product Details Card -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Images Gallery -->
                            <div class="w-full md:w-1/3 space-y-4">
                                <div
                                    class="aspect-square w-full rounded-xl bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                    @if($product->images->count() > 0)
                                        <img src="{{ $product->images->first()->display_url }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-slate-400">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($product->images->skip(1) as $imgModel)
                                        <div
                                            class="aspect-square rounded-lg bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                            <img src="{{ $imgModel->display_url }}" alt=""
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 space-y-6">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $product->name }}
                                    </h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        Sold by <span
                                            class="font-medium text-slate-700 dark:text-slate-300">{{ $product->user->name ?? 'Unknown' }}</span>
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">Price</p>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                            ${{ number_format((float) $product->price, 2) }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">Category</p>
                                        <p class="text-lg font-semibold text-slate-900 dark:text-white">
                                            {{ $product->category->name ?? 'None' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-white">Description</h4>
                                    <div
                                        class="mt-2 text-sm text-slate-600 dark:text-slate-300 prose prose-sm dark:prose-invert max-w-none">
                                        {{ $product->description }}
                                    </div>
                                </div>

                                @if($product->expiration_date instanceof \DateTimeInterface)
                                    <div>
                                        <h4 class="text-sm font-medium text-slate-900 dark:text-white">Expiration Date</h4>
                                        <p class="text-sm text-slate-600 dark:text-slate-300">
                                            {{ $product->expiration_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moderation Actions -->
                <form action="{{ route('admin.products.update', $product) }}" method="POST"
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Moderation Status</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300">Product
                                Status</label>
                            <p class="text-xs text-slate-500 mb-2">Change the visibility of this product.</p>
                            <select id="status" name="status"
                                class="block w-full max-w-md rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <option value="pending" {{ $product->status === 'pending' ? 'selected' : '' }}>Pending
                                    Review</option>
                                <option value="approved" {{ $product->status === 'approved' ? 'selected' : '' }}>Approved
                                    (Live)</option>
                                <option value="rejected" {{ $product->status === 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ $product->is_featured ? 'checked' : '' }}
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-slate-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                Suggest as Featured Product
                            </label>
                        </div>

                        <div
                            class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <a href="{{ route('admin.products.index') }}"
                                class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

            </div>
</x-layouts.admin-dashboard>