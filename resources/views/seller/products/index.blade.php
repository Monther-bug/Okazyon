<x-layouts.seller-dashboard>
    <x-slot:title>Products</x-slot>
        <x-slot:header>Product Management</x-slot>

            <div x-data="{ showAddModal: false, search: '' }" class="relative">

                <!-- Top Actions Table Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div class="relative max-w-md w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" x-model="search" placeholder="Search products..."
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-800 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all shadow-sm">
                    </div>

                    <button @click="showAddModal = true"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-red-600/20 hover:shadow-red-600/40 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Product
                    </button>
                </div>

                @if($products->isEmpty())
                    <!-- Empty State -->
                    <div
                        class="flex flex-col items-center justify-center min-h-[400px] text-center p-8 bg-white dark:bg-gray-900 rounded-3xl border border-dashed border-gray-200 dark:border-gray-800">
                        <div
                            class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No products found</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-6">Your inventory is currently empty. Get
                            started by adding your first product.</p>
                        <button @click="showAddModal = true" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                            Create new product &rarr;
                        </button>
                    </div>
                @else
                    <!-- Data Table -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="bg-gray-50/50 dark:bg-gray-800/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-6 py-4">Product</th>
                                        <th class="px-6 py-4">Price</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($products as $product)
                                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="h-12 w-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700">
                                                        @if($product->images && count($product->images) > 0)
                                                            <img src="{{ Storage::url($product->images[0]) }}"
                                                                alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                        @else
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900 dark:text-white text-sm">
                                                            {{ $product->name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 truncate max-w-[200px]">
                                                            {{ Str::limit($product->description, 40) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                                    @if($product->discounted_price)
                                                        <span
                                                            class="text-xs text-gray-400 line-through">${{ number_format($product->discounted_price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                    Active
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div
                                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <a href="{{ route('seller.products.edit', $product) }}"
                                                        class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('seller.products.destroy', $product) }}"
                                                        method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif

                <!-- Slide-Over Sidebar (Alpine.js) -->
                <div class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
                    x-show="showAddModal" style="display: none;">

                    <!-- Backdrop -->
                    <div x-show="showAddModal" x-transition:enter="ease-in-out duration-500"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"
                        @click="showAddModal = false"></div>

                    <div class="fixed inset-0 overflow-hidden">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                                <!-- Panel -->
                                <div x-show="showAddModal"
                                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                    class="pointer-events-auto w-screen max-w-md">

                                    <form action="{{ route('seller.products.store') }}" method="POST"
                                        enctype="multipart/form-data"
                                        class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-900 shadow-2xl">
                                        @csrf

                                        <!-- Header -->
                                        <div
                                            class="px-4 py-6 sm:px-6 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 sticky top-0 z-10">
                                            <div class="flex items-start justify-between">
                                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">New Product
                                                </h2>
                                                <button type="button" @click="showAddModal = false"
                                                    class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close panel</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Get started by filling in the
                                                information below.</p>
                                        </div>

                                        <!-- Body -->
                                        <div class="relative flex-1 px-4 py-6 sm:px-6 space-y-6">

                                            <!-- Image Upload -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Product
                                                    Images</label>
                                                <div
                                                    class="mt-1 flex justify-center rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 px-6 pt-5 pb-6 hover:border-red-500 transition-colors bg-gray-50 dark:bg-gray-800/50">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400"
                                                            stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                            <path
                                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <div
                                                            class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                                            <label for="images"
                                                                class="relative cursor-pointer rounded-md font-bold text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                                                <span>Upload files</span>
                                                                <input id="images" name="images[]" type="file" multiple
                                                                    class="sr-only">
                                                            </label>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="name"
                                                    class="block text-sm font-bold text-gray-900 dark:text-white">Product
                                                    Name</label>
                                                <input type="text" name="name" id="name" required
                                                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors">
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="price"
                                                        class="block text-sm font-bold text-gray-900 dark:text-white">Price</label>
                                                    <div class="relative mt-1 rounded-xl shadow-sm">
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                            <span class="text-gray-500 sm:text-sm">$</span>
                                                        </div>
                                                        <input type="number" name="price" id="price" step="0.01"
                                                            required
                                                            class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white pl-7 focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors"
                                                            placeholder="0.00">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="discounted_price"
                                                        class="block text-sm font-bold text-gray-900 dark:text-white">Discount
                                                        Price</label>
                                                    <div class="relative mt-1 rounded-xl shadow-sm">
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                            <span class="text-gray-500 sm:text-sm">$</span>
                                                        </div>
                                                        <input type="number" name="discounted_price"
                                                            id="discounted_price" step="0.01"
                                                            class="block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white pl-7 focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors"
                                                            placeholder="0.00">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="category_id"
                                                    class="block text-sm font-bold text-gray-900 dark:text-white">Category</label>
                                                <select id="category_id" name="category_id" required
                                                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors">
                                                    <option value="">Select a category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="description"
                                                    class="block text-sm font-bold text-gray-900 dark:text-white">Description</label>
                                                <textarea id="description" name="description" rows="4" required
                                                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors"></textarea>
                                            </div>

                                            <div class="relative flex items-start">
                                                <div class="flex h-6 items-center">
                                                    <input id="status" name="status" type="checkbox" value="active"
                                                        checked
                                                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                                                </div>
                                                <div class="ml-3 text-sm leading-6">
                                                    <label for="status"
                                                        class="font-medium text-gray-900 dark:text-white">Active
                                                        Product</label>
                                                    <p class="text-gray-500">Product will be visible to customers.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Footer -->
                                        <div
                                            class="flex-shrink-0 border-t border-gray-100 dark:border-gray-800 px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-900/50 flex justify-end gap-3 sticky bottom-0">
                                            <button type="button" @click="showAddModal = false"
                                                class="rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-bold text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="inline-flex justify-center rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Save Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</x-layouts.seller-dashboard>