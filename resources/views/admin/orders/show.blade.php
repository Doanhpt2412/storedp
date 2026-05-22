<x-layouts.admin title="Chi tiết đơn hàng #{{ $order->order_code }}">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    Đơn hàng <span class="text-blue-600">#{{ $order->order_code }}</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">Đặt lúc {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Form xóa đơn hàng -->
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Thao tác này không thể hoàn tác.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    Xóa
                </button>
            </form>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm leading-5 font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-800">Sản phẩm đã mua</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $order->items->count() }} sản phẩm</span>
                </div>
                <div class="p-0">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Sản phẩm</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Đơn giá</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">SL</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach ($order->items as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 h-16 w-16 bg-white border border-slate-200 rounded-lg p-1 flex items-center justify-center">
                                                <img class="max-h-full max-w-full object-contain" src="{{ $item->product_image }}" alt="">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-bold text-slate-900 truncate" title="{{ $item->product_name }}">{{ $item->product_name }}</p>
                                                @if($item->variant_info)
                                                    <p class="text-xs text-slate-500 mt-1">{{ $item->variant_info }}</p>
                                                @endif
                                                @if($item->sku)
                                                    <p class="text-xs text-slate-400 mt-0.5">SKU: {{ $item->sku }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900">{{ number_format($item->price, 0, ',', '.') }}đ</div>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="text-sm text-slate-900">{{ $item->quantity }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900">{{ number_format($item->total, 0, ',', '.') }}đ</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-500">Tạm tính:</span>
                        <span class="font-medium text-slate-900">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-500">Phí giao hàng:</span>
                        <span class="font-medium text-emerald-600">Miễn phí</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-500">Mã khuyến mãi:</span>
                        <span class="font-medium text-slate-900">{{ $order->promotion_code ?: 'Không áp dụng' }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-500">Giảm giá:</span>
                        <span class="font-medium text-emerald-600">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="flex justify-between text-base font-bold mt-4 pt-4 border-t border-slate-200">
                        <span class="text-slate-800">Tổng cộng:</span>
                        <span class="text-red-600 text-xl">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Cập nhật trạng thái -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="text-lg font-bold text-slate-800">Cập nhật đơn hàng</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="order_status" class="block text-sm font-medium text-slate-700 mb-2">Trạng thái hiện tại</label>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'shipping' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                                ];
                                $colorClass = $statusColors[$order->order_status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                            @endphp
                            <div class="mb-4 inline-flex px-3 py-1.5 rounded-lg border text-sm font-bold {{ $colorClass }}">
                                {{ $order->status_label }}
                            </div>

                            <select id="order_status" name="order_status" class="mt-1 block w-full pl-3 pr-10 py-2.5 text-base border border-slate-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg transition-colors">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipping" {{ $order->order_status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <h2 class="text-lg font-bold text-slate-800">Khách hàng</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Họ và tên</p>
                        <p class="text-sm font-medium text-slate-900">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Điện thoại liên hệ</p>
                        <a href="tel:{{ $order->customer_phone }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $order->customer_phone }}</a>
                    </div>
                    @if($order->customer_email)
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</p>
                        <a href="mailto:{{ $order->customer_email }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $order->customer_email }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <h2 class="text-lg font-bold text-slate-800">Thông tin nhận hàng</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Hình thức</p>
                        <div class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold bg-slate-100 text-slate-800">
                            {{ $order->delivery_label }}
                        </div>
                    </div>
                    
                    @if($order->delivery_method === 'home_delivery')
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Địa chỉ giao hàng</p>
                        <p class="text-sm text-slate-800 leading-relaxed">{{ $order->customer_address }}</p>
                    </div>
                    @endif

                    @if($order->customer_note)
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Ghi chú của khách</p>
                        <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-lg text-sm text-yellow-800">
                            {{ $order->customer_note }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
