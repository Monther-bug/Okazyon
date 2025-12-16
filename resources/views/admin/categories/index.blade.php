<x-layouts.admin-dashboard>
    <x-slot:title>Categories Management</x-slot>
        <x-slot:header>Categories</x-slot>

            <div class="space-y-6">

                <!-- Filters & Actions -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">

                    <!-- Search -->
                    <form method="GET" class="relative flex-1 max-w-lg">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out"
                            placeholder="Search categories...">
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            New Category
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
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Products
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
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
                                                <div class="ml-4">
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
                                                {{ $category->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($category->is_active)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 rounded-full border border-emerald-200 dark:border-emerald-500/20">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-400 rounded-full border border-slate-200 dark:border-slate-600">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                            {{ $category->products_count ?? 0 }} items
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                                </form>
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
                                                <p class="text-base font-medium">No categories found</p>
                                                <p class="text-sm mt-1">Get started by creating a new category.</p>
                                                <a href="{{ route('admin.categories.create') }}"
                                                    class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                                    Create Category
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