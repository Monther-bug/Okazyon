<x-layouts.admin-dashboard>
    <x-slot:title>{{ __('user.edit_user') }}</x-slot>
        <x-slot:header>{{ __('user.edit_user_name', ['name' => $user->name]) }}</x-slot>

            <div class="max-w-3xl mx-auto">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 space-y-6">

                        <!-- Errors -->
                        @if ($errors->any())
                            <div
                                class="rounded-xl bg-red-50 dark:bg-red-500/10 p-4 border border-red-200 dark:border-red-500/20">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-400">
                                            {{ __('user.error_submission') }}
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul role="list" class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Personal Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="first_name"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('user.first_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name" required
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="mt-1 block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:border-red-500 focus:ring-red-500 sm:text-sm">
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('user.last_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name" required
                                    value="{{ old('last_name', $user->last_name) }}"
                                    class="mt-1 block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:border-red-500 focus:ring-red-500 sm:text-sm">
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label for="phone_number"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('user.phone_number') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone_number" id="phone_number" required
                                    value="{{ old('phone_number', $user->phone_number) }}"
                                    class="mt-1 block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('user.phone_help') }}
                                </p>
                            </div>
                        </div>

                        <!-- Account Settings -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-200 dark:border-slate-700">

                            <!-- Role -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('user.role') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    @foreach(['user', 'seller', 'buyer', 'admin'] as $role)
                                        <option value="{{ $role }}" {{ old('type', $user->type) === $role ? 'selected' : '' }}>
                                            {{ __('user.role_' . $role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($user->id === auth()->id())
                                    <p class="mt-1 text-xs text-amber-600 font-medium">{{ __('user.role_help') }}
                                    </p>
                                @endif
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('user.status') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                    @foreach(['active', 'inactive', 'banned'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $user->status->value ?? $user->status) === $status ? 'selected' : '' }}>
                                            {{ __('user.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                {{ __('user.cancel') }}
                            </a>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                {{ __('user.save_changes') }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>
</x-layouts.admin-dashboard>