<x-layouts.app :title="'Thanh toán | ' . config('app.name')" :navCategories="$navCategories ?? []">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="mb-8">
            <p class="mb-1 text-sm font-bold uppercase tracking-[0.2em] text-orange-500">Thanh toán an toàn</p>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Hoàn tất đơn hàng</h1>
        </div>

        <div class="grid items-start gap-8 lg:grid-cols-[1fr_400px]">
            <div>
                <form id="checkout-order-form" action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 flex items-center gap-2 text-lg font-bold text-gray-900">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-sm text-blue-600">1</span>
                            Thông tin liên hệ
                        </h2>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="customer_name" class="mb-1 block text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 transition-colors focus:border-blue-500 focus:ring-blue-500 @error('customer_name') border-red-500 @enderror" placeholder="Nhập họ và tên của bạn">
                                @error('customer_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="customer_phone" class="mb-1 block text-sm font-medium text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                                <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 transition-colors focus:border-blue-500 focus:ring-blue-500 @error('customer_phone') border-red-500 @enderror" placeholder="VD: 0987654321">
                                @error('customer_phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="customer_email" class="mb-1 block text-sm font-medium text-gray-700">Email (Không bắt buộc)</label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 transition-colors focus:border-blue-500 focus:ring-blue-500 @error('customer_email') border-red-500 @enderror" placeholder="Để nhận email xác nhận đơn hàng">
                                @error('customer_email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="mb-4 flex items-center gap-2 text-lg font-bold text-gray-900">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-sm text-blue-600">2</span>
                            Hình thức nhận hàng
                        </h2>

                        <div class="mb-6 grid gap-4 sm:grid-cols-2">
                            <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition-all has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                <input type="radio" name="delivery_method" value="home_delivery" class="sr-only" {{ old('delivery_method', 'home_delivery') === 'home_delivery' ? 'checked' : '' }} onchange="toggleAddressField(this.value)">
                                <div class="flex w-full items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><path d="m9 16 3-3 3 3"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">Giao tận nhà</p>
                                        <p class="text-xs text-gray-500">Miễn phí giao hàng toàn quốc</p>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition-all has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                <input type="radio" name="delivery_method" value="store_pickup" class="sr-only" {{ old('delivery_method') === 'store_pickup' ? 'checked' : '' }} onchange="toggleAddressField(this.value)">
                                <div class="flex w-full items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-orange-50 text-orange-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">Nhận tại cửa hàng</p>
                                        <p class="text-xs text-gray-500">Đến trực tiếp cửa hàng StoreDP</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="address_field_container" class="{{ old('delivery_method', 'home_delivery') === 'store_pickup' ? 'hidden' : '' }} space-y-4 overflow-hidden transition-all duration-300">
                            <div>
                                <label for="customer_address" class="mb-1 block text-sm font-medium text-gray-700">Địa chỉ giao hàng <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 transition-colors focus:border-blue-500 focus:ring-blue-500 @error('customer_address') border-red-500 @enderror" placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố">
                                @error('customer_address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="customer_note" class="mb-1 block text-sm font-medium text-gray-700">Ghi chú thêm (Không bắt buộc)</label>
                            <textarea id="customer_note" name="customer_note" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 transition-colors focus:border-blue-500 focus:ring-blue-500 @error('customer_note') border-red-500 @enderror" placeholder="Ghi chú về thời gian giao hàng, yêu cầu đóng gói...">{{ old('customer_note') }}</textarea>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="sticky top-24">
                <div class="mb-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-4 flex items-center justify-between border-b border-gray-100 pb-4 text-lg font-bold text-gray-900">
                        Tóm tắt đơn hàng
                        <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Sửa giỏ hàng</a>
                    </h2>

                    <div class="custom-scrollbar mb-6 max-h-[350px] space-y-4 overflow-y-auto pr-2 pt-2">
                        @foreach ($cartItems as $item)
                            <div class="flex items-start gap-3">
                                <div class="relative flex h-16 w-16 shrink-0 items-center justify-center rounded-lg border border-gray-100 bg-gray-50 p-1">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                    <span class="absolute -right-1 -top-1 flex h-6 min-w-6 items-center justify-center rounded-full border-2 border-white bg-orange-500 px-1.5 text-[11px] font-bold leading-none text-white shadow-sm">{{ $item['quantity'] }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="line-clamp-2 text-sm font-bold leading-snug text-gray-900">{{ $item['name'] }}</h4>
                                    <div class="mt-0.5 space-x-1 text-[11px] text-gray-500">
                                        @if($item['storage'])<span>{{ $item['storage'] }}</span>@endif
                                        @if($item['storage'] && $item['color'])<span>|</span>@endif
                                        @if($item['color'])<span>{{ $item['color'] }}</span>@endif
                                    </div>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-sm font-extrabold text-gray-900">{{ number_format($item['price_value'] * $item['quantity'], 0, ',', '.') }}đ</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-6 rounded-xl border border-dashed border-orange-200 bg-orange-50/60 p-4">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900">Mã khuyến mãi</h3>
                            @if ($appliedPromotion)
                                <form action="{{ route('checkout.promotion.remove') }}" method="POST" class="promotion-sync-form">
                                    @csrf
                                    @method('DELETE')
                                    <div class="promotion-form-fields hidden"></div>
                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:underline">Gỡ mã</button>
                                </form>
                            @endif
                        </div>

                        <form action="{{ route('checkout.promotion.apply') }}" method="POST" class="promotion-sync-form flex gap-2">
                            @csrf
                            <div class="promotion-form-fields hidden"></div>
                            <input type="text" name="promotion_code" value="{{ old('promotion_code', $appliedPromotion['code'] ?? '') }}" class="min-w-0 flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm uppercase" placeholder="Nhập mã khuyến mãi">
                            <button type="submit" class="rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-orange-700">Áp mã</button>
                        </form>

                        @if (session('promotion_success'))
                            <p class="mt-2 text-xs font-medium text-emerald-600">{{ session('promotion_success') }}</p>
                        @endif
                        @if (session('promotion_error'))
                            <p class="mt-2 text-xs font-medium text-red-500">{{ session('promotion_error') }}</p>
                        @endif
                        @error('promotion_code') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror

                        @if ($appliedPromotion)
                            <div class="mt-3 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700">
                                <p class="font-bold">{{ $appliedPromotion['name'] }}</p>
                                <p>Mã <span class="font-semibold">{{ $appliedPromotion['code'] }}</span> giảm <span class="font-semibold">{{ $appliedPromotion['discount_percentage'] }}%</span> tổng bill.</p>
                                <p class="mt-1">Bạn được giảm <span class="font-semibold">{{ number_format($appliedPromotion['discount_amount'], 0, ',', '.') }}đ</span>.</p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3 border-t border-gray-100 pt-4">
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
                            <span class="font-semibold {{ $discountAmount > 0 ? 'text-emerald-600' : 'text-gray-400' }}">-{{ number_format($discountAmount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="mt-4 flex items-end justify-between border-t border-gray-100 pt-4">
                        <span class="text-base font-bold text-gray-900">Tổng cộng</span>
                        <div class="text-right">
                            <span class="text-2xl font-black leading-none text-red-600">{{ number_format($checkoutTotal, 0, ',', '.') }}đ</span>
                            <p class="mt-1 text-[11px] text-gray-500">(Đã tính giảm giá nếu mã hợp lệ)</p>
                        </div>
                    </div>
                </div>

                <button type="submit" form="checkout-order-form" class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-orange-500 px-6 py-4 text-base font-bold text-white shadow-xl shadow-red-500/20 transition-all hover:opacity-95 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    HOÀN TẤT ĐẶT HÀNG
                </button>
            </aside>
        </div>
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

        function syncCheckoutFieldsToPromotionForms() {
            const sourceForm = document.getElementById('checkout-order-form');

            if (!sourceForm) {
                return;
            }

            const syncedFields = [
                'customer_name',
                'customer_phone',
                'customer_email',
                'customer_address',
                'customer_note',
            ];

            document.querySelectorAll('.promotion-sync-form').forEach((form) => {
                const container = form.querySelector('.promotion-form-fields');

                if (!container) {
                    return;
                }

                container.innerHTML = '';

                syncedFields.forEach((fieldName) => {
                    const source = sourceForm.querySelector(`[name="${fieldName}"]`);

                    if (!source) {
                        return;
                    }

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = fieldName;
                    input.value = source.value;
                    container.appendChild(input);
                });

                const selectedDelivery = sourceForm.querySelector('input[name="delivery_method"]:checked');
                if (selectedDelivery) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delivery_method';
                    input.value = selectedDelivery.value;
                    container.appendChild(input);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const checkedRadio = document.querySelector('input[name="delivery_method"]:checked');
            if (checkedRadio) {
                toggleAddressField(checkedRadio.value);
            }

            syncCheckoutFieldsToPromotionForms();

            const sourceForm = document.getElementById('checkout-order-form');
            if (sourceForm) {
                sourceForm.addEventListener('input', syncCheckoutFieldsToPromotionForms);
                sourceForm.addEventListener('change', syncCheckoutFieldsToPromotionForms);
            }

            document.querySelectorAll('.promotion-sync-form').forEach((form) => {
                form.addEventListener('submit', syncCheckoutFieldsToPromotionForms);
            });
        });
    </script>
</x-layouts.app>
