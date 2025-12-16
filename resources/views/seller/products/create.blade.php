<x-layouts.seller-dashboard>
    <x-slot:title>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</x-slot>
        <x-slot:header>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</x-slot>

            <div class="space-y-6 font-sans antialiased">
                <!-- Breadcrumb / Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in-up">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ isset($product) ? 'Edit Product' : 'Create New Product' }}
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">
                            {{ isset($product) ? 'Update product details and inventory.' : 'Fill in the details to add a new item to your catalog.' }}
                        </p>
                    </div>
                    <a href="{{ route('seller.products.index') }}"
                        class="inline-flex items-center text-gray-500 hover:text-gray-900 font-medium transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Inventory
                    </a>
                </div>

                <form
                    action="{{ isset($product) ? route('seller.products.update', $product) : route('seller.products.store') }}"
                    method="POST" enctype="multipart/form-data" class="animate-fade-in-up"
                    style="animation-delay: 0.1s;">

                    @csrf
                    @if(isset($product))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column (Main Info) -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Basic Details Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Basic
                                    Information</h3>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Product
                                            Name</label>
                                        <input type="text" name="name" id="name" required
                                            value="{{ old('name', $product->name ?? '') }}"
                                            placeholder="e.g. Signature Leather Jacket"
                                            class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all py-3 px-4">
                                        @error('name') <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div>
                                        <label for="description"
                                            class="block text-sm font-bold text-gray-900 mb-2">Description</label>
                                        <textarea name="description" id="description" rows="6" required
                                            placeholder="Detailed description of your product..."
                                            class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all py-3 px-4">{{ old('description', $product->description ?? '') }}</textarea>
                                        @error('description') <p class="mt-1 text-sm text-red-600 font-medium">
                                            {{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Images Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                                    <h3 class="text-lg font-bold text-gray-900">Product Media</h3>
                                    <span
                                        class="text-xs font-semibold px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg">Max
                                        5 Images</span>
                                </div>

                                <!-- Existing Images Preview (if editing) -->
                                @if(isset($product) && $product->images)
                                    <div class="mb-6">
                                        <p class="text-sm font-bold text-gray-700 mb-3">Current Images</p>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach(is_array($product->images) ? $product->images : json_decode($product->images) as $img)
                                                <div
                                                    class="relative group w-32 h-32 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-gray-50">
                                                    <input type="hidden" name="existing_images[]" value="{{ $img }}">
                                                    <img src="{{ Storage::url($img) }}" alt="Product Image"
                                                        class="w-full h-full object-cover">

                                                    <button type="button" onclick="this.closest('.relative').remove()"
                                                        class="absolute top-1 right-1 p-1.5 bg-red-500 rounded-full text-white shadow-sm hover:bg-red-600 transition-colors z-10"
                                                        title="Remove Image">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload Area -->
                                <div class="space-y-4">
                                    <label for="images" id="drop-zone"
                                        class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-red-50 hover:border-red-400 transition-all group overflow-hidden">
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4 relative z-10">
                                            <div
                                                class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <p class="mb-2 text-sm text-gray-500 font-medium group-hover:text-gray-700">
                                                <span class="font-bold text-red-600">Click to upload</span> or drag and
                                                drop
                                            </p>
                                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                        <input id="images" name="images[]" type="file" class="hidden" multiple
                                            accept="image/*" onchange="handleFileSelect(this)" />
                                        <!-- Drag overlay -->
                                        <div id="drag-overlay"
                                            class="absolute inset-0 bg-red-50/90 hidden flex-col items-center justify-center z-20 transition-opacity">
                                            <svg class="w-10 h-10 text-red-500 animate-bounce mb-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-red-600 font-bold">Drop files here</p>
                                        </div>
                                    </label>

                                    <!-- Preview Container -->
                                    <div id="preview-container" class="flex flex-wrap gap-4 mt-4 empty:hidden">
                                        <!-- Previews will be injected here -->
                                    </div>
                                </div>

                                @error('images') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                @error('images.*') <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <script>
                                const maxImages = 5;
                                let selectedFiles = new DataTransfer();

                                const dropZone = document.getElementById('drop-zone');
                                const dragOverlay = document.getElementById('drag-overlay');
                                const input = document.getElementById('images');

                                // Drag & Drop events
                                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                    dropZone.addEventListener(eventName, preventDefaults, false);
                                });

                                function preventDefaults(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                }

                                ['dragenter', 'dragover'].forEach(eventName => {
                                    dropZone.addEventListener(eventName, highlight, false);
                                });

                                ['dragleave', 'drop'].forEach(eventName => {
                                    dropZone.addEventListener(eventName, unhighlight, false);
                                });

                                function highlight(e) {
                                    dropZone.classList.add('border-red-400', 'bg-red-50');
                                    dragOverlay.classList.remove('hidden');
                                    dragOverlay.classList.add('flex');
                                }

                                function unhighlight(e) {
                                    dropZone.classList.remove('border-red-400', 'bg-red-50');
                                    dragOverlay.classList.add('hidden');
                                    dragOverlay.classList.remove('flex');
                                }

                                dropZone.addEventListener('drop', handleDrop, false);

                                function handleDrop(e) {
                                    const dt = e.dataTransfer;
                                    const files = dt.files;
                                    handleFiles(files);
                                }

                                function handleFileSelect(inputElement) {
                                    const files = inputElement.files;
                                    handleFiles(files);
                                }

                                function handleFiles(files) {
                                    if (selectedFiles.items.length + files.length > maxImages) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Limit Reached',
                                            text: `You can only upload a maximum of ${maxImages} images.`,
                                            confirmButtonColor: '#EF4444'
                                        });
                                        return;
                                    }

                                    [...files].forEach(file => {
                                        // Double check duplicates visually? (Optional, skipping for now)
                                        selectedFiles.items.add(file);
                                    });

                                    updateInputAndPreview();
                                }

                                function updateInputAndPreview() {
                                    input.files = selectedFiles.files;
                                    const container = document.getElementById('preview-container');
                                    container.innerHTML = ''; // Clear current previews

                                    [...selectedFiles.files].forEach((file, index) => {
                                        const reader = new FileReader();
                                        reader.readAsDataURL(file);
                                        reader.onloadend = function () {
                                            const div = document.createElement('div');
                                            div.className = 'relative group w-32 h-32 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-gray-50';
                                            div.innerHTML = `
                                        <img src="${reader.result}" class="w-full h-full object-cover">
                                        <button type="button" onclick="removeFile(${index})" 
                                            class="absolute top-1 right-1 p-1 bg-white rounded-full text-red-500 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50" title="Remove">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    `;
                                            container.appendChild(div);
                                        }
                                    });
                                }

                                function removeFile(index) {
                                    const dt = new DataTransfer();
                                    const files = selectedFiles.files;

                                    for (let i = 0; i < files.length; i++) {
                                        if (index !== i) {
                                            dt.items.add(files[i]);
                                        }
                                    }

                                    selectedFiles = dt;
                                    updateInputAndPreview();
                                }
                            </script>
                        </div>

                        <!-- Right Column (Settings) -->
                        <div class="space-y-6">

                            <!-- Organization Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-base font-bold text-gray-900 mb-4">Organization</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="category_id"
                                            class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                        <div class="relative">
                                            <select name="category_id" id="category_id" required
                                                class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all py-3 px-4 appearance-none">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old('category_id') == $category->id || (isset($product) && $product->category_id == $category->id)) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('category_id') <p class="mt-1 text-sm text-red-600 font-medium">
                                            {{ $message }}
                                        </p> @enderror
                                    </div>


                                </div>
                            </div>

                            <!-- Pricing Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-base font-bold text-gray-900 mb-4">Pricing</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Regular
                                            Price</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <div
                                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                <span class="text-gray-500 font-bold">$</span>
                                            </div>
                                            <input type="number" step="0.01" name="price" id="price" required
                                                value="{{ old('price', $product->price ?? '') }}" placeholder="0.00"
                                                class="block w-full rounded-xl border-gray-200 bg-gray-50 pl-10 text-gray-900 focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all py-3">
                                        </div>
                                        @error('price') <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div>
                                        <label for="discounted_price"
                                            class="block text-sm font-bold text-gray-700 mb-2">Discount Price</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <div
                                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                                <span class="text-gray-500 font-bold">$</span>
                                            </div>
                                            <input type="number" step="0.01" name="discounted_price"
                                                id="discounted_price"
                                                value="{{ old('discounted_price', $product->discounted_price ?? '') }}"
                                                placeholder="0.00"
                                                class="block w-full rounded-xl border-gray-200 bg-gray-50 pl-10 text-gray-900 focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all py-3">
                                        </div>
                                        @error('discounted_price') <p class="mt-1 text-sm text-red-600 font-medium">
                                            {{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full py-4 px-6 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all transform flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ isset($product) ? 'Update Product' : 'Create Product' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Danger Zone (Delete) - Only in Edit Mode -->
                @if(isset($product))
                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <div
                            class="bg-red-50 rounded-2xl border border-red-100 p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Delete Product</h3>
                                <p class="text-red-600 text-sm mt-1">Once you delete this product, there is no going back.
                                    Please be certain.</p>
                            </div>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-2.5 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all shadow-sm">
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
</x-layouts.seller-dashboard>