<x-layouts.seller-dashboard>
    <x-slot:title>Products</x-slot>
        <x-slot:header>{{ __('Product Management') }}</x-slot>

            <div class="space-y-8 font-sans antialiased">



                <!-- Success Message Toast (Handled by SweetAlert) -->
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: false,
                                background: '#10B981',
                                color: '#ffffff',
                                iconColor: '#ffffff',
                                customClass: {
                                    popup: 'rounded-xl shadow-lg border border-green-500/20'
                                },
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: "{{ session('success') }}"
                            })
                        });
                    </script>
                @endif

                <!-- Empty State -->
                @if($products->isEmpty())
                    <div class="bg-gray-50/50 dark:bg-gray-900/50 rounded-3xl p-12 text-center animate-fade-in-up flex flex-col items-center justify-center min-h-[400px]">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 mb-6">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No products yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto mb-6">
                            Your inventory is empty. Use the "Add Product" button to get started.
                        </p>
                        <a href="{{ route('seller.products.create') }}"
                           class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Product
                        </a>
                    </div>
                @else

                    <!-- Header with Add Product Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Products</h2>
                        <a href="{{ route('seller.products.create') }}"
                           class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Product
                        </a>
                    </div>

                    <!-- Search, Filter & Export Bar -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 mb-8 animate-fade-in-up">
                        <form method="GET" action="{{ route('seller.products.index') }}" class="flex flex-col sm:flex-row items-center gap-4">
                            <!-- Search Input -->
                            <div class="flex-1 w-full">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                        placeholder="Search by name or description..." 
                                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all shadow-sm">
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-3 shrink-0">
                                <button type="submit" 
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Search
                                </button>
                                
                                <a href="{{ route('seller.products.export') }}" 
                                    class="px-6 py-3 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2"
                                    style="background-color: #16a34a;">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export
                                </a>

                                @if(request('search'))
                                    <a href="{{ route('seller.products.index') }}" 
                                        class="p-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl transition-all border border-gray-200 dark:border-gray-700"
                                        title="Clear search">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Products Table -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden animate-fade-in-up"
                        style="animation-delay: 0.1s;">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-gray-800/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-6 py-4">Product</th>
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Price</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($products as $product)
                                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer" onclick="window.location='{{ route('seller.products.show', $product) }}'">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden flex-shrink-0 shadow-sm relative">
                                                        @if($product->images->count() > 0)
                                                            <img src="{{ $product->images->first()->display_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="font-bold text-gray-900 dark:text-white text-sm mb-0.5 truncate">{{ $product->name }}</div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500 truncate max-w-[200px]">{{ Str::limit($product->description, 50) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    @if($product->discounted_price)
                                                        <span class="text-gray-400 dark:text-gray-500 line-through text-[10px] font-medium">${{ number_format($product->price, 2) }}</span>
                                                        <span class="font-bold text-gray-900 dark:text-white text-sm">${{ number_format($product->discounted_price, 2) }}</span>
                                                    @else
                                                        <span class="font-bold text-gray-900 dark:text-white text-sm">${{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $productStatusClass = match ($product->status) {
                                                        'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                        default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $productStatusClass }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('seller.products.edit', $product) }}"
                                                        class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                                        title="Edit" onclick="event.stopPropagation();">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="delete-form inline" onclick="event.stopPropagation();">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="delete-btn p-1.5 rounded-lg text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

                        <!-- Pagination -->
                        @if($products->hasPages())
                            <div class="px-8 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Script for Delete Confirmation -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const deleteBtns = document.querySelectorAll('.delete-btn');

                            deleteBtns.forEach(btn => {
                                btn.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    const form = this.closest('form');

                                    Swal.fire({
                                        title: '<span class="text-xl font-bold text-gray-900">Delete Product?</span>',
                                        html: '<p class="text-gray-500 text-sm mt-2">This action cannot be undone. The product will be permanently removed.</p>',
                                        icon: 'warning',
                                        iconColor: '#fee2e2',
                                        showCancelButton: true,
                                        confirmButtonColor: '#EF4444',
                                        cancelButtonColor: '#F3F4F6',
                                        confirmButtonText: 'Yes, delete it',
                                        cancelButtonText: 'Cancel',
                                        reverseButtons: true,
                                        focusCancel: true,
                                        buttonsStyling: false,
                                        customClass: {
                                            popup: 'rounded-3xl shadow-2xl border border-gray-100 p-0',
                                            icon: '!border-0 !text-red-500',
                                            confirmButton: 'bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 ml-3',
                                            cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl font-bold text-sm transition-all',
                                            actions: 'gap-3 mb-6'
                                        },
                                        width: '24rem',
                                        padding: '2rem'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    })
                                });
                            });
                        });
                    </script>
                @endif
            </div>
</x-layouts.seller-dashboard>