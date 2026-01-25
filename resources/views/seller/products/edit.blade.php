<x-layouts.seller-dashboard>
    <x-slot:heading>{{ __('products_form.edit_title') }}</x-slot:heading>
    <x-slot:subheading>{{ __('products_form.edit_desc') }}</x-slot:subheading>

    <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data"
        class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('dashboard.basic_info') }}
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('products_form.product_name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                class="w-full rounded-lg border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="{{ __('products_form.placeholder_name') }}">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('products_form.product_description') }}</label>
                            <textarea name="description" id="description" rows="5" required
                                class="w-full rounded-lg border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="{{ __('products_form.placeholder_desc') }}">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('products_form.images') }}
                    </h3>

                    <!-- Existing Images -->
                    @if($product->images && count($product->images) > 0)
                        <div class="mb-4 grid grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <div
                                    class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                    <img src="{{ isset($image['url']) ? $image['url'] : asset('storage/' . $image) }}"
                                        class="object-cover w-full h-full">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="images"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">{{ __('products_form.upload_images') }}</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                        800x400px)</p>
                                </div>
                                <input id="images" name="images[]" type="file" class="hidden" multiple
                                    accept="image/*" />
                            </label>
                        </div>
                        @error('images') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @error('images.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings, Pricing, Organization -->
            <div class="space-y-6">
                <!-- Status -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('products_form.status') }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="flex flex-col">
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ __('products_form.active') }}</span>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400">{{ __('products_form.product_visible') }}</span>
                        </span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="approved" class="sr-only peer" {{ old('status', $product->status) === 'approved' ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Pricing -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('products_form.pricing') }}
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('products_form.price') }}
                                ($)</label>
                            <input type="number" step="0.01" name="price" id="price"
                                value="{{ old('price', $product->price) }}" required
                                class="w-full rounded-lg border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="0.00">
                            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="discounted_price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discounted Price
                                ($)</label>
                            <input type="number" step="0.01" name="discounted_price" id="discounted_price"
                                value="{{ old('discounted_price', $product->discounted_price) }}"
                                class="w-full rounded-lg border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 transition-colors"
                                placeholder="0.00">
                            @error('discounted_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Organization -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('products_form.organization') }}</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('products_form.category') }}</label>
                            <select name="category_id" id="category_id" required
                                class="w-full rounded-lg border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500 transition-colors">
                                <option value="">{{ __('products_form.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="button" onclick="history.back()"
                class="px-6 py-2.5 mr-4 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                {{ __('products_form.cancel') }}
            </button>
            <button type="submit"
                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('products_form.update_product') }}
            </button>
        </div>
    </form>
</x-layouts.seller-dashboard>