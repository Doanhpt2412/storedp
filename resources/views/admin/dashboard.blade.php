<x-layouts.admin title="Bảng điều khiển">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Bảng điều khiển</h1>
            <p class="text-sm text-slate-500 mt-1">Tổng quan về hoạt động kinh doanh hôm nay.</p>
        </div>
        <div>
            <button class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Xuất báo cáo
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 border-l-4 border-l-blue-500 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Doanh thu ngày</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">12,500,000₫</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-emerald-500 font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    +15%
                </span>
                <span class="text-slate-400 ml-2">so với hôm qua</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 border-l-4 border-l-emerald-500 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Đơn hàng mới</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">45</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-emerald-500 font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    +8%
                </span>
                <span class="text-slate-400 ml-2">so với hôm qua</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 border-l-4 border-l-amber-500 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Khách hàng mới</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">12</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-rose-500 font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
                    -2%
                </span>
                <span class="text-slate-400 ml-2">so với hôm qua</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 border-l-4 border-l-rose-500 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Sản phẩm sắp hết</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">5</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="#" class="text-blue-600 font-medium hover:underline flex items-center">
                    Xem danh sách
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800">Đơn hàng gần đây</h2>
            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 font-semibold">Mã đơn</th>
                        <th class="px-6 py-4 font-semibold">Khách hàng</th>
                        <th class="px-6 py-4 font-semibold">Sản phẩm</th>
                        <th class="px-6 py-4 font-semibold">Tổng tiền</th>
                        <th class="px-6 py-4 font-semibold">Trạng thái</th>
                        <th class="px-6 py-4 font-semibold text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-blue-600">#ORD-1024</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">Nguyễn Văn A</div>
                            <div class="text-xs text-slate-500">0987654321</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">iPhone 15 Pro Max 256GB</td>
                        <td class="px-6 py-4 font-bold text-slate-800">29,990,000₫</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Hoàn thành</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-blue-600">#ORD-1023</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">Trần Thị B</div>
                            <div class="text-xs text-slate-500">0912345678</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">MacBook Air M2 8GB/256GB</td>
                        <td class="px-6 py-4 font-bold text-slate-800">23,500,000₫</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">Đang xử lý</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-blue-600">#ORD-1022</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">Lê Văn C</div>
                            <div class="text-xs text-slate-500">0909090909</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">Tai nghe AirPods Pro 2</td>
                        <td class="px-6 py-4 font-bold text-slate-800">5,890,000₫</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full">Đã huỷ</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
