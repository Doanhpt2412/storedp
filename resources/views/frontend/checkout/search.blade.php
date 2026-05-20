<x-layouts.app :title="'Tra cứu đơn hàng | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 rotate-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v3l2 2"/></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Tra cứu đơn hàng</h1>
            <p class="text-gray-500">Kiểm tra trạng thái và tiến trình đơn hàng của bạn nhanh chóng.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-gray-100 p-8 md:p-10 mb-10">
            <form action="{{ route('checkout.search') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="relative flex items-center">
                    <div class="absolute left-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nhập Mã đơn hàng (VD: DP-...) hoặc Số điện thoại" required
                        class="w-full pl-12 pr-32 py-4 rounded-2xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-base font-medium outline-none">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 rounded-xl transition-colors shadow-sm">
                        Tra cứu
                    </button>
                </div>
                <p class="text-xs text-center text-gray-400 mt-4">Thông tin của bạn được bảo mật an toàn.</p>
            </form>
        </div>

        @if(request()->has('q'))
            @if($orders && $orders->count() > 0)
                <div class="space-y-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Kết quả tìm kiếm ({{ $orders->count() }} đơn hàng)</h2>
                    
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                            <!-- Header Đơn hàng -->
                            <div class="bg-slate-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="font-black text-lg text-blue-600 tracking-wider">{{ $order->order_code }}</span>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'shipping' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
                                            ];
                                            $statusClass = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                        @endphp
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-md border {{ $statusClass }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-sm text-gray-500 mb-0.5">Tổng tiền</p>
                                    <p class="text-lg font-extrabold text-red-600">{{ number_format($order->total, 0, ',', '.') }}đ</p>
                                </div>
                            </div>

                            <!-- Thân Đơn hàng -->
                            <div class="p-6">
                                <div class="grid md:grid-cols-2 gap-8 mb-6">
                                    <!-- Cột TT người mua -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 pb-2 border-b border-gray-100">Thông tin người mua</h3>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="text-gray-500 inline-block w-24">Họ tên:</span> <span class="font-medium text-gray-900">{{ $order->customer_name }}</span></p>
                                            <p><span class="text-gray-500 inline-block w-24">Điện thoại:</span> <span class="font-medium text-gray-900">{{ $order->customer_phone }}</span></p>
                                            <p><span class="text-gray-500 inline-block w-24">Hình thức:</span> <span class="font-medium text-emerald-600">{{ $order->delivery_label }}</span></p>
                                            @if($order->delivery_method === 'home_delivery')
                                                <p><span class="text-gray-500 inline-block w-24 align-top">Địa chỉ:</span> <span class="font-medium text-gray-900 inline-block w-[calc(100%-6rem)]">{{ $order->customer_address }}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Cột Sản phẩm -->
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 pb-2 border-b border-gray-100">Sản phẩm đã mua</h3>
                                        <div class="space-y-3 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center justify-between text-sm">
                                                    <div class="flex-1 min-w-0 pr-4">
                                                        <p class="font-medium text-gray-900 truncate" title="{{ $item->product_name }}">{{ $item->product_name }}</p>
                                                        @if($item->variant_info)
                                                            <p class="text-xs text-gray-500">{{ $item->variant_info }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="shrink-0 text-right">
                                                        <span class="text-gray-500 text-xs mr-2">x{{ $item->quantity }}</span>
                                                        <span class="font-semibold text-gray-900">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Thanh tiến trình -->
                                @php
                                    $steps = ['pending', 'processing', 'shipping', 'completed'];
                                    $currentIndex = array_search($order->order_status, $steps);
                                    if ($order->order_status === 'cancelled') {
                                        $currentIndex = -1; // Hủy
                                    }
                                @endphp
                                
                                @if($order->order_status !== 'cancelled')
                                <div class="mt-8 relative">
                                    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-100 -translate-y-1/2 rounded-full"></div>
                                    <div class="absolute top-1/2 left-0 h-1 bg-emerald-500 -translate-y-1/2 rounded-full transition-all duration-1000" style="width: {{ $currentIndex === false ? 0 : ($currentIndex / (count($steps) - 1)) * 100 }}%"></div>
                                    
                                    <div class="relative flex justify-between">
                                        <!-- Step 1 -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full border-4 {{ $currentIndex >= 0 ? 'bg-emerald-500 border-white text-white' : 'bg-gray-100 border-white text-gray-400' }} flex items-center justify-center shadow-sm z-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            </div>
                                            <p class="text-[10px] sm:text-xs font-semibold mt-2 {{ $currentIndex >= 0 ? 'text-emerald-700' : 'text-gray-400' }}">Chờ xác nhận</p>
                                        </div>
                                        <!-- Step 2 -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full border-4 {{ $currentIndex >= 1 ? 'bg-emerald-500 border-white text-white' : 'bg-gray-100 border-white text-gray-400' }} flex items-center justify-center shadow-sm z-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            </div>
                                            <p class="text-[10px] sm:text-xs font-semibold mt-2 {{ $currentIndex >= 1 ? 'text-emerald-700' : 'text-gray-400' }}">Đang xử lý</p>
                                        </div>
                                        <!-- Step 3 -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full border-4 {{ $currentIndex >= 2 ? 'bg-emerald-500 border-white text-white' : 'bg-gray-100 border-white text-gray-400' }} flex items-center justify-center shadow-sm z-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                                            </div>
                                            <p class="text-[10px] sm:text-xs font-semibold mt-2 {{ $currentIndex >= 2 ? 'text-emerald-700' : 'text-gray-400' }}">Đang giao</p>
                                        </div>
                                        <!-- Step 4 -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full border-4 {{ $currentIndex >= 3 ? 'bg-emerald-500 border-white text-white' : 'bg-gray-100 border-white text-gray-400' }} flex items-center justify-center shadow-sm z-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="7.5 4.21 12 6.81 16.5 4.21"/><polyline points="7.5 19.79 7.5 14.6 3 12"/><polyline points="21 12 16.5 14.6 16.5 19.79"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                            </div>
                                            <p class="text-[10px] sm:text-xs font-semibold mt-2 {{ $currentIndex >= 3 ? 'text-emerald-700' : 'text-gray-400' }}">Hoàn thành</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-gray-100 border-dashed">
                    <div class="w-16 h-16 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Không tìm thấy đơn hàng</h3>
                    <p class="text-gray-500">Xin lỗi, chúng tôi không tìm thấy đơn hàng nào khớp với "<strong>{{ request('q') }}</strong>". Vui lòng kiểm tra lại.</p>
                </div>
            @endif
        @endif
    </section>
</x-layouts.app>
