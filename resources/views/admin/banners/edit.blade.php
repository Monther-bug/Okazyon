<x-layouts.admin-dashboard>
    <x-slot:title>Edit Banner</x-slot>
        <x-slot:header>Edit Banner: {{ $banner->title }}</x-slot>

            <div class="max-w-3xl mx-auto">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Card -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6 space-y-6">

                        <!-- Title -->
                        <div>
                            <label for="title"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300">Banner
                                Title</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" required
                                    value="{{ old('title', $banner->title) }}"
                                    class="block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                    placeholder="e.g. Big Winter Sale">
                            </div>
                        </div>

                        <!-- Subtitle -->
                        <div>
                            <label for="subtitle"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300">Subtitle
                                (Optional)</label>
                            <div class="mt-1">
                                <input type="text" name="subtitle" id="subtitle"
                                    value="{{ old('subtitle', $banner->subtitle) }}"
                                    class="block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                    placeholder="e.g. Up to 50% Off">
                            </div>
                        </div>

                        <!-- Link -->
                        <div>
                            <label for="link"
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300">Target Link
                                (Optional)</label>
                            <div class="mt-1">
                                <input type="url" name="link" id="link" value="{{ old('link', $banner->link) }}"
                                    class="block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                    placeholder="e.g. https://okazyon.com/categories/sale">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Banner
                                Image</label>

                            <div class="mt-2 mb-4">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="Current Image"
                                    class="w-full h-48 object-cover rounded-lg border border-slate-200 dark:border-slate-600">
                                <p class="mt-1 text-xs text-slate-500">Current Image</p>
                            </div>

                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors cursor-pointer group"
                                onclick="document.getElementById('image').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-red-500 transition-colors"
                                        stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                        <label for="image"
                                            class="relative cursor-pointer rounded-md font-medium text-red-600 dark:text-red-400 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                            <span>Upload new file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">to replace</p>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        PNG, JPG, GIF up to 2MB (High Resolution recommended)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-slate-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                Set as Active Banner
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.banners.index') }}"
                            class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Update Banner
                        </button>
                    </div>
                </form>
            </div>
</x-layouts.admin-dashboard>