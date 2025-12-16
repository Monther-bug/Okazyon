<x-layouts.seller-dashboard>
    <x-slot:title>Products</x-slot>
        <x-slot:header>{{ __('Product Management') }}</x-slot>

            <div class="space-y-8 font-sans antialiased">

                <!-- Header Section -->
                <div class="relative overflow-hidden animate-fade-in-up"
                     style="background: linear-gradient(to right, #dc2626, #ef4444); box-shadow: 0 10px 30px -5px rgba(220, 38, 38, 0.3); border-radius: 24px; padding: 40px;">

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-2">Inventory</h1>
                    <p class="text-white text-base sm:text-lg font-medium opacity-90 max-w-xl">
                        Manage your product catalog and stock with ease.
                    </p>
                </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('seller.products.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-700 font-bold text-base rounded-xl shadow-lg hover:bg-gray-50 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Product
                            </a>
                        </div>
                    </div>
                </div>

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
                    <div class="bg-gray-50/50 rounded-3xl p-12 text-center animate-fade-in-up flex flex-col items-center justify-center min-h-[400px]">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 text-gray-400 mb-6">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No products yet</h3>
                        <p class="text-gray-500 max-w-sm mx-auto">
                            Your inventory is empty. Use the "Add Product" button above to get started.
                        </p>
                    </div>
                @else

                    <!-- Products Table -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up"
                        style="animation-delay: 0.1s;">
                        <div class="overflow-x-auto p-4"> <!-- Added padding for spacing context -->
                            <table class="w-full text-left text-gray-600 border-separate border-spacing-y-2">
                                <!-- separate border for row spacing -->
                                <thead class="text-xs uppercase font-bold text-gray-400 tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 pl-8">Product</th> <!-- Adjusted padding -->
                                        <th class="px-6 py-4">Category</th>
                                        <th class="px-6 py-4">Price</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 pr-8 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr class="group hover:bg-red-50/40 transition-colors duration-200">
                                            <td class="px-6 py-4 pl-8 rounded-l-2xl border-t border-b border-l border-transparent mb-2 bg-white group-hover:border-red-100 group-hover:bg-red-50/40 cursor-pointer" onclick="window.location='{{ route('seller.products.show', $product) }}'">
                                                <div class="flex items-center gap-6"> <!-- Increased gap -->
                                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 shadow-sm relative group-hover:shadow transition-all">
                                                        @if(is_array($product->images) && count($product->images) > 0)
                                                            <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="font-bold text-gray-900 text-base mb-1 group-hover:text-red-600 transition-colors truncate">{{ $product->name }}</div>
                                                        <div class="text-sm text-gray-400 truncate max-w-[200px]">{{ Str::limit($product->description, 50) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 border-t border-b border-transparent bg-white group-hover:border-red-100 group-hover:bg-red-50/40">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    {{ $product->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 border-t border-b border-transparent bg-white group-hover:border-red-100 group-hover:bg-red-50/40">
                                                <div class="flex flex-col">
                                                    @if($product->discounted_price)
                                                        <span
                                                            class="text-gray-400 line-through text-xs font-medium">${{ number_format($product->price, 2) }}</span>
                                                        <span
                                                            class="font-bold text-gray-900 text-base">${{ number_format($product->discounted_price, 2) }}</span>
                                                    @else
                                                        <span
                                                            class="font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 border-t border-b border-transparent bg-white group-hover:border-red-100 group-hover:bg-red-50/40">
                                                <div class="flex items-center gap-2">
                                                    @if($product->status === 'approved')
                                                        <span class="relative flex h-2.5 w-2.5">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                                        </span>
                                                        <span class="text-xs font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full border border-green-200">Approved</span>
                                                    @else
                                                        <span class="relative flex h-2.5 w-2.5">
                                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-yellow-400"></span>
                                                        </span>
                                                        <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full border border-yellow-200">Pending</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 pr-8 text-right rounded-r-2xl border-t border-b border-r border-transparent bg-white group-hover:border-red-100 group-hover:bg-red-50/40">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('seller.products.edit', $product) }}"
                                                        class="p-2.5 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all shadow-sm hover:shadow border border-transparent hover:border-blue-100"
                                                        title="Edit">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('seller.products.destroy', $product) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="delete-btn p-2.5 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all shadow-sm hover:shadow border border-transparent hover:border-red-100"
                                                            title="Delete">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                            <div class="px-8 py-5 border-t border-gray-100 bg-gray-50/50">
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