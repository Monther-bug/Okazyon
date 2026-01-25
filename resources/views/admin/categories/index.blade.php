<x-layouts.admin-dashboard>
    <x-slot:title>{{ __('categories.management') }}</x-slot>
        <x-slot:header>{{ __('categories.title') }}</x-slot>

            <div class="space-y-6">

                <!-- Filters & Actions -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">

                    <!-- Search -->
                    <form method="GET" class="relative flex-1 max-w-lg">
                        <div class="absolute inset-y-0 start-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 rtl:pr-10 rtl:pl-3 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                            placeholder="{{ __('categories.search_placeholder') }}">
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="-ml-1 rtl:ml-2 mr-2 rtl:mr-0 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('categories.new_category') }}
                        </a>
                    </div>
                </div>

                <!-- Categories Table -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('categories.name') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('categories.type') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('categories.status') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('categories.products') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">{{ __('categories.actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($category->image)
                                                        <img class="h-10 w-10 rounded-lg object-cover border border-slate-200 dark:border-slate-600"
                                                            src="{{ asset('storage/' . $category->image) }}"
                                                            alt="{{ $category->name }}">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 font-bold">
                                                            {{ substr($category->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4 rtl:mr-4 rtl:ml-0">
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $category->name }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        /{{ $category->slug }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 capitalize">
                                                {{ __('categories.type_' . $category->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($category->is_active)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 rounded-full border border-emerald-200 dark:border-emerald-500/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    {{ __('categories.active') }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-400 rounded-full border border-slate-200 dark:border-slate-600">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                    {{ __('categories.inactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                            {{ $category->products_count ?? 0 }} {{ __('categories.items') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">{{ __('categories.edit') }}</a>
                                                <button type="button" @click="$dispatch('open-delete-modal', {
                                                                            action: '{{ route('admin.categories.destroy', $category) }}',
                                                                            title: '{{ __('categories.delete_title') }}',
                                                                            message: '{{ __('categories.delete_message', ['name' => $category->name]) }}'
                                                                        })"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    {{ __('categories.delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <p class="text-base font-medium">{{ __('categories.no_categories_found') }}
                                                </p>
                                                <p class="text-sm mt-1">{{ __('categories.start_creating') }}</p>
                                                <a href="{{ route('admin.categories.create') }}"
                                                    class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                                    {{ __('categories.create_category') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div
                            class="bg-white dark:bg-slate-800 px-4 py-3 border-t border-slate-200 dark:border-slate-700 sm:px-6">
                            {{ $categories->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
</x-layouts.admin-dashboard>