<x-layouts.admin-dashboard>
    <x-slot:title>Banners Management</x-slot>
        <x-slot:header>Banners</x-slot>

            <div class="space-y-6">

                <!-- Header Actions -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                    <div class="flex-1">
                        <h3 class="text-base font-medium text-slate-900 dark:text-white">Promotional Banners</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Manage homepage banners and sliders.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.banners.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            New Banner
                        </a>
                    </div>
                </div>

                <!-- Banners Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($banners as $banner)
                        <div
                            class="group relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <!-- Image -->
                            <div class="aspect-video w-full bg-slate-100 dark:bg-slate-700 relative overflow-hidden">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                                @if($banner->is_active)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-500/90 dark:text-white rounded-full shadow-sm backdrop-blur-sm">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-white"></span>
                                            Active
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-5 space-y-3">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white line-clamp-1">
                                        {{ $banner->title }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1">
                                        {{ $banner->subtitle ?? 'No subtitle' }}</p>
                                </div>

                                @if($banner->link)
                                    <div class="text-xs text-red-600 dark:text-red-400 truncate">
                                        <a href="{{ $banner->link }}" target="_blank"
                                            class="hover:underline">{{ $banner->link }}</a>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div
                                    class="pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                                    <div class="text-xs text-slate-400">
                                        {{ $banner->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.banners.edit', $banner) }}"
                                            class="p-2 text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" 
                                            @click="$dispatch('open-delete-modal', { 
                                                action: '{{ route('admin.banners.destroy', $banner) }}', 
                                                title: 'Delete Banner', 
                                                message: 'Are you sure you want to delete the banner &quot;{{ $banner->title }}&quot;? This action cannot be undone.' 
                                            })"
                                            class="p-2 text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl border-dashed">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">No banners</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Get started by adding a new banner.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.banners.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    New Banner
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
</x-layouts.admin-dashboard>