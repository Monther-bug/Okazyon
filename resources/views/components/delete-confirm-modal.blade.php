<div x-data="{ 
        open: false, 
        actionUrl: '', 
        title: 'Delete Item', 
        message: 'Are you sure you want to delete this item? This action cannot be undone.' 
    }" @open-delete-modal.window="
        open = true; 
        actionUrl = $event.detail.action; 
        title = $event.detail.title || 'Delete Item'; 
        message = $event.detail.message || 'Are you sure you want to delete this item? This action cannot be undone.'
    " @keydown.escape.window="open = false" class="relative z-50" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" x-show="open" style="display: none;" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" x-show="open"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200 dark:border-slate-700"
                @click.outside="open = false" x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="p-6">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div
                            class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-50 dark:bg-red-500/10 mb-5">
                            <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white" id="modal-title"
                            x-text="title"></h3>
                        <div class="mt-3">
                            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-[280px] mx-auto leading-relaxed"
                                x-text="message"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-700/30 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                    <form method="POST" :action="actionUrl" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-500/30 hover:bg-red-700 hover:shadow-red-500/40 sm:w-auto transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transform active:scale-95">
                            Delete
                        </button>
                    </form>
                    <button type="button" @click="open = false"
                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white dark:bg-slate-800 px-5 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:w-auto transition-all transform active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>