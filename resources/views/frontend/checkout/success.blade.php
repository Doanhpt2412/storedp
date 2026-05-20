<x-layouts.app :title="'Đặt hàng thành công | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="max-w-3xl mx-auto px-4 py-12 text-center">
        <!-- Success Icon & Confetti -->
        <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-75"></div>
            <div class="relative flex items-center justify-center w-full h-full bg-green-500 rounded-full shadow-lg shadow-green-500/30 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Đặt hàng thành công!</h1>
        <p class="text-gray-500 mb-8 max-w-lg mx-auto">Cảm ơn <span class="font-bold text-gray-900">{{ $order->customer_name }}</span> đã tin tưởng mua sắm tại StoreDP. Yêu cầu đặt hàng của bạn đã được tiếp nhận và đang chờ xử lý.</p>

        <!-- Order Code Card (Glassmorphic) -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden mb-10 text-left border border-slate-700">
            <!-- Decorative circle -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mb-1">Mã đơn hàng của bạn</p>
                    <div class="flex items-center gap-3">
                        <span class="text-4xl md:text-5xl font-black text-white tracking-wider" id="order-code">{{ $order->order_code }}</span>
                        <button onclick="copyOrderCode()" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all backdrop-blur-md" title="Sao chép mã">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        </button>
                    </div>
                    <p class="text-slate-400 text-xs mt-3 bg-slate-800/50 inline-block px-3 py-1.5 rounded-lg border border-slate-700">Vui lòng lưu lại mã này để tra cứu đơn hàng.</p>
                </div>

                <div class="text-left md:text-right border-t md:border-t-0 md:border-l border-slate-700/50 pt-4 md:pt-0 md:pl-6">
                    <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Thành tiền</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($order->total, 0, ',', '.') }}đ</p>
                    <p class="text-slate-400 text-xs uppercase tracking-wider mt-3 mb-1">Hình thức</p>
                    <p class="text-sm font-semibold text-emerald-400">{{ $order->delivery_label }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('checkout.search') }}?q={{ $order->order_code }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white border border-gray-200 px-6 py-3.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                Tra cứu tiến trình
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3.5 text-sm font-bold text-white hover:opacity-95 transition-all shadow-lg shadow-blue-500/20">
                Tiếp tục mua sắm
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </section>

    <script>
        function copyOrderCode() {
            const code = document.getElementById('order-code').innerText;
            navigator.clipboard.writeText(code).then(() => {
                if (typeof window.showToast === 'function') {
                    window.showToast({
                        type: 'success',
                        title: 'Đã sao chép',
                        message: 'Mã đơn hàng đã được lưu vào bộ nhớ tạm.'
                    });
                } else {
                    alert('Đã sao chép: ' + code);
                }
            });
        }
    </script>
</x-layouts.app>
