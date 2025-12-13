<x-layouts.seller-dashboard>
    <div x-data="{ showAddModal: false, search: '' }" class="min-h-screen">

        <!-- Main Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Products</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your store's inventory and catalog.</p>
            </div>

            <button @click="showAddModal = true"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-2xl transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Product
            </button>
        </div>

        <!-- Content Area -->
        @if($products->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-8">
                <div
                    class="w-24 h-24 bg-gradient-to-tr from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl flex items-center justify-center mb-6 shadow-xl shadow-gray-200/50 dark:shadow-black/50 ring-1 ring-gray-100 dark:ring-gray-800">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No products found</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-8 leading-relaxed">Your inventory is currently empty.
                    Get started by adding your first product to your store.</p>
                <button @click="showAddModal = true"
                    class="text-red-600 dark:text-red-400 font-semibold hover:text-red-700 dark:hover:text-red-300 transition-colors flex items-center gap-2">
                    Add your first product
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </button>
            </div>
        @else
            <!-- Product List -->
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-black/20 overflow-hidden">
                <!-- Search & Filter Bar -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="search" placeholder="Search products..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border-transparent focus:border-red-500 focus:ring-0 focus:bg-white dark:focus:bg-gray-900 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 transition-all">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 dark:bg-gray-800/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800">
                                <th class="px-8 py-5">Product</th>
                                <th class="px-6 py-5">Price</th>
                                <th class="px-6 py-5">Category</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($products as $product)
                                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-200">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-5">
                                            <div
                                                class="h-14 w-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm relative group-hover:shadow-md transition-shadow">
                                                @if($product->images && count($product->images) > 0)
                                                    <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 dark:text-white text-base mb-0.5">
                                                    {{ $product->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 font-medium">
                                                    {{ Str::limit($product->description, 30) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800/30">
                                            <span class="relative flex h-2 w-2">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                            <a href="{{ route('seller.products.edit', $product) }}"
                                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
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
            </div>
        @endif

        <!-- Premium Centered Modal -->
        <!-- Slide-Over Drawer -->
        <div class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
            x-show="showAddModal" style="display: none;">
            <!-- Background backdrop -->
            <div x-show="showAddModal" x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 dark:bg-black/80 backdrop-blur-sm transition-opacity"
                @click="showAddModal = false"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <!-- Slide-over panel -->
                        <div x-show="showAddModal"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            class="pointer-events-auto w-screen max-w-2xl">

                            <form id="addProductForm" action="{{ route('seller.products.store') }}" method="POST"
                                enctype="multipart/form-data"
                                class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-900 shadow-2xl"
                                x-data="{ 
                                    images: [],
                                    handleFileSelect(event) {
                                        const files = event.target.files;
                                        if (files) {
                                            for (let i = 0; i < files.length; i++) {
                                                const file = files[i];
                                                if (file.type.startsWith('image/')) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        this.images.push(e.target.result);
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            }
                                        }
                                    }
                                }">
                                @csrf

                                <!-- Header -->
                                <div
                                    class="px-4 py-6 sm:px-6 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 sticky top-0 z-20">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-900 dark:text-white"
                                                id="slide-over-title">
                                                New Product
                                            </h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Add a new item to your inventory.
                                            </p>
                                        </div>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button type="button" @click="showAddModal = false"
                                                class="rounded-full bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="relative flex-1 px-4 py-6 sm:px-6 space-y-8">

                                    <!-- Image Upload Section -->
                                    <div class="space-y-4">
                                        <label class="block text-sm font-bold text-gray-900 dark:text-white">Product
                                            Images</label>

                                        <!-- Image Grid -->
                                        <div class="grid grid-cols-3 gap-4 mb-4" x-show="images.length > 0">
                                            <template x-for="(image, index) in images" :key="index">
                                                <div
                                                    class="relative aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 group">
                                                    <img :src="image" class="h-full w-full object-cover">
                                                    <button type="button"
                                                        @click="images = images.filter((_, i) => i !== index)"
                                                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Upload Box -->
                                        <label
                                            class="group relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-900/50 hover:bg-white dark:hover:bg-gray-800 hover:border-red-500 dark:hover:border-red-500 transition-all duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-red-500 transition-colors"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p
                                                    class="text-sm text-gray-500 dark:text-gray-400 font-medium group-hover:text-red-500 transition-colors">
                                                    Click to upload images</p>
                                            </div>
                                            <input type="file" name="images[]" multiple class="hidden" accept="image/*"
                                                @change="handleFileSelect" />
                                        </label>
                                    </div>

                                    <!-- Basic Info -->
                                    <div class="space-y-5">
                                        <!-- Status Toggle -->
                                        <div
                                            class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">Active
                                                    Status</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Product will be
                                                    visible to customers.</span>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="status" value="approved"
                                                    class="sr-only peer" checked>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600">
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="name"
                                                class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Product
                                                Name</label>
                                            <input type="text" name="name" id="name" required
                                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-[#eeecec] dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3"
                                                placeholder="e.g. Wireless Headphones">
                                        </div>

                                        <div class="grid grid-cols-2 gap-5">
                                            <div>
                                                <label for="price"
                                                    class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Price</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 font-bold">$</span>
                                                    </div>
                                                    <input type="number" name="price" id="price" step="0.01" required
                                                        class="w-full pl-7 pr-4 rounded-xl border-gray-200 dark:border-gray-700 bg-[#eeecec] dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3 font-medium"
                                                        placeholder="0.00">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="discounted_price"
                                                    class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Discount
                                                    Price</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 font-bold">$</span>
                                                    </div>
                                                    <input type="number" name="discounted_price" id="discounted_price"
                                                        step="0.01"
                                                        class="w-full pl-7 pr-4 rounded-xl border-gray-200 dark:border-gray-700 bg-[#eeecec] dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3 font-medium"
                                                        placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="category_id"
                                                class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Category</label>
                                            <div class="relative">
                                                <select name="category_id" id="category_id" required
                                                    class="w-full appearance-none rounded-xl border-gray-200 dark:border-gray-700 bg-[#eeecec] dark:bg-gray-700 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3 pl-4 pr-10">
                                                    <option value="">Select a category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="description"
                                                class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Description</label>
                                            <textarea name="description" id="description" rows="4" required
                                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-[#eeecec] dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3"
                                                placeholder="Describe your product..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div
                                    class="shrink-0 border-t border-gray-100 dark:border-gray-800 px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-900/50 sticky bottom-0 z-20 flex justify-end gap-3">
                                    <button type="button" @click="showAddModal = false"
                                        class="px-5 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 border border-transparent rounded-xl shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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