<x-layouts.app :title="'Thanh toán | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-8">
            <p class="text-sm uppercase tracking-[0.2em] text-orange-500 font-bold mb-1">Thanh toán an toàn</p>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Hoàn tất đơn hàng</h1>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-[1fr_400px] gap-8 items-start">
            @csrf

            <!-- Cột trái: Thông tin cá nhân -->
            <div class="space-y-8">
                <!-- Thông tin liên hệ -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm">1</span>
                        Thông tin liên hệ
                    </h2>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('customer_name') border-red-500 @enderror" placeholder="Nhập họ và tên của bạn">
                            @error('customer_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('customer_phone') border-red-500 @enderror" placeholder="VD: 0987654321">
                            @error('customer_phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email (Không bắt buộc)</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('customer_email') border-red-500 @enderror" placeholder="Để nhận email xác nhận đơn hàng">
                            @error('customer_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Hình thức nhận hàng -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm">2</span>
                        Hình thức nhận hàng
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-4 mb-6">
                        <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm focus:outline-none has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500 transition-all">
                            <input type="radio" name="delivery_method" value="home_delivery" class="sr-only" {{ old('delivery_method', 'home_delivery') === 'home_delivery' ? 'checked' : '' }} onchange="toggleAddressField(this.value)">
                            <div class="flex items-center gap-3 w-full">
                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><path d="m9 16 3-3 3 3"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">Giao tận nhà</p>
                                    <p class="text-xs text-gray-500">Miễn phí giao hàng toàn quốc</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm focus:outline-none has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500 transition-all">
                            <input type="radio" name="delivery_method" value="store_pickup" class="sr-only" {{ old('delivery_method') === 'store_pickup' ? 'checked' : '' }} onchange="toggleAddressField(this.value)">
                            <div class="flex items-center gap-3 w-full">
                                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-900">Nhận tại cửa hàng</p>
                                    <p class="text-xs text-gray-500">Đến trực tiếp cửa hàng StoreDP</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div id="address_field_container" class="space-y-4 transition-all duration-300 overflow-hidden {{ old('delivery_method', 'home_delivery') === 'store_pickup' ? 'hidden' : '' }}">
                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng <span class="text-red-500">*</span></label>
                            <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address') }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('customer_address') border-red-500 @enderror" placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố">
                            @error('customer_address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="customer_note" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú thêm (Không bắt buộc)</label>
                        <textarea id="customer_note" name="customer_note" rows="3"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-colors @error('customer_note') border-red-500 @enderror" placeholder="Ghi chú về thời gian giao hàng, yêu cầu đóng gói...">{{ old('customer_note') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Đơn hàng -->
            <aside class="sticky top-24">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 pb-4 border-b border-gray-100 flex items-center justify-between">
                        Tóm tắt đơn hàng
                        <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Sửa giỏ hàng</a>
                    </h2>

                    <div class="space-y-4 mb-6 max-h-[350px] overflow-y-auto pr-2 pt-2 custom-scrollbar">
                        @foreach ($cartItems as $item)
                            <div class="flex gap-3 items-start">
                                <div class="w-16 h-16 rounded-lg border border-gray-100 bg-gray-50 flex items-center justify-center p-1 relative shrink-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="max-w-full max-h-full object-contain">
                                    <span class="absolute -top-1 -right-1 min-w-6 h-6 px-1.5 bg-orange-500 text-white rounded-full flex items-center justify-center text-[11px] font-bold border-2 border-white shadow-sm leading-none">{{ $item['quantity'] }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug">{{ $item['name'] }}</h4>
                                    <div class="text-[11px] text-gray-500 mt-0.5 space-x-1">
                                        @if($item['storage'])<span>{{ $item['storage'] }}</span>@endif
                                        @if($item['storage'] && $item['color'])<span>|</span>@endif
                                        @if($item['color'])<span>{{ $item['color'] }}</span>@endif
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-extrabold text-gray-900">{{ number_format($item['price_value'] * $item['quantity'], 0, ',', '.') }}đ</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Tạm tính ({{ $cartCount }} sản phẩm)</span>
                            <span class="font-semibold">{{ number_format($cartSubtotal, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Phí vận chuyển</span>
                            <span class="font-semibold text-green-600">Miễn phí</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Giảm giá</span>
                            <span class="font-semibold text-gray-400">0đ</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-end">
                        <span class="text-base font-bold text-gray-900">Tổng cộng</span>
                        <div class="text-right">
                            <span class="text-2xl font-black text-red-600 leading-none">{{ number_format($cartSubtotal, 0, ',', '.') }}đ</span>
                            <p class="text-[11px] text-gray-500 mt-1">(Không bao gồm thanh toán trực tuyến)</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-red-600 to-orange-500 hover:opacity-95 text-white font-bold py-4 px-6 text-base transition-all shadow-xl shadow-red-500/20 active:scale-[0.98] flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    HOÀN TẤT ĐẶT HÀNG
                </button>
            </aside>
        </form>
    </section>

    <script>
        function toggleAddressField(method) {
            const container = document.getElementById('address_field_container');
            const input = document.getElementById('customer_address');
            
            if (method === 'store_pickup') {
                container.classList.add('hidden');
                input.required = false;
            } else {
                container.classList.remove('hidden');
                input.required = true;
            }
        }
        
        // Run on init
        document.addEventListener('DOMContentLoaded', () => {
            const checkedRadio = document.querySelector('input[name="delivery_method"]:checked');
            if (checkedRadio) {
                toggleAddressField(checkedRadio.value);
            }
        });
    </script>
</x-layouts.app>
