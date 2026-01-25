<x-layouts.admin-dashboard>
    <x-slot:title>{{ __('user.management') }}</x-slot>
        <x-slot:header>{{ __('user.title') }}</x-slot>

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
                            placeholder="{{ __('user.search_placeholder') }}">
                    </form>

                    <div class="flex items-center gap-3">
                        <!-- Export / Actions (Placeholder) -->
                        <!-- Export / Actions -->
                        <a href="{{ route('admin.users.export') }}"
                            class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm text-sm font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 rtl:ml-2 mr-2 rtl:mr-0 h-5 w-5 text-slate-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {{ __('user.export') }}
                        </a>
                    </div>
                </div>

                <!-- Users Table -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('user.header_user') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('user.header_contact') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('user.header_role') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        {{ __('user.header_joined') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">{{ __('user.actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                @forelse($users as $user)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover border border-slate-200 dark:border-slate-600"
                                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff"
                                                        alt="{{ $user->name }}">
                                                </div>
                                                <div class="ml-4 rtl:mr-4 rtl:ml-0">
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('user.id') }}: #{{ $user->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-900 dark:text-white">
                                                {{ $user->phone_number ?? __('user.na') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                                {{ $user->role ?? 'User' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-3">
                                                @unless($user->type === 'admin')
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300 font-medium">{{ __('user.edit') }}</a>

                                                    <button type="button" @click="$dispatch('open-delete-modal', {
                                                                                            action: '{{ route('admin.users.destroy', $user) }}',
                                                                                            title: '{{ __('user.delete_title') }}',
                                                                                            message: '{{ __('user.delete_message', ['name' => $user->name]) }}'
                                                                                        })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium bg-transparent border-none p-0 cursor-pointer">
                                                        {{ __('user.delete') }}
                                                    </button>
                                                @endunless
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-10 w-10 text-slate-400 mb-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <p class="text-base font-medium">{{ __('user.no_users') }}</p>
                                                <p class="text-sm mt-1">{{ __('user.adjust_search') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div
                            class="bg-white dark:bg-slate-800 px-4 py-3 border-t border-slate-200 dark:border-slate-700 sm:px-6">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
</x-layouts.admin-dashboard>