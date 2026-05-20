<x-layouts.admin title="Quản lý Đơn hàng">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý Đơn hàng</h1>
            <p class="text-sm text-slate-500 mt-1">Quản lý và theo dõi trạng thái các đơn đặt hàng.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Tìm theo mã đơn, SĐT hoặc tên khách hàng...">
                </div>
            </div>
            
            <div class="w-full md:w-64">
                <select name="status" class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipping" {{ request('status') === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-700 transition duration-150 ease-in-out shadow-sm">
                    Lọc
                </button>
                @if(request()->has('q') || request()->has('status'))
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 text-sm leading-5 font-medium rounded-lg text-slate-700 bg-white hover:text-slate-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-slate-800 active:bg-slate-50 transition duration-150 ease-in-out shadow-sm">
                        Xóa lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm leading-5 font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mã đơn</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Khách hàng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Ngày đặt</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tổng tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-blue-600">{{ $order->order_code }}</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $order->items_count }} sản phẩm</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $order->customer_name }}</div>
                                <div class="text-sm text-slate-500">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ $order->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-slate-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-red-600">{{ number_format($order->total, 0, ',', '.') }}đ</div>
                                <div class="text-xs text-slate-500">{{ $order->delivery_label }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipping' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-emerald-100 text-emerald-800',
                                        'cancelled' => 'bg-rose-100 text-rose-800',
                                    ];
                                    $colorClass = $statusColors[$order->order_status] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Xem chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-base font-medium">Không tìm thấy đơn hàng nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
