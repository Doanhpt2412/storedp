<x-layouts.admin title="Quản lý Tài khoản">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý Tài khoản</h1>
            <p class="text-sm text-slate-500 mt-1">Danh sách tất cả tài khoản quản trị và phân quyền tương ứng.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-md shadow-blue-500/20 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Thêm tài khoản
            </a>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 font-semibold">Tên tài khoản</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Vai trò</th>
                        <th class="px-6 py-4 font-semibold">Trạng thái</th>
                        <th class="px-6 py-4 font-semibold">Ngày tạo</th>
                        <th class="px-6 py-4 font-semibold text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center border border-slate-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                                        @if(auth()->id() === $user->id)
                                            <span class="ml-1.5 px-1.5 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-medium rounded border border-blue-100">Tôi</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if ($user->role === 'admin')
                                    <span class="px-2.5 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-100 uppercase tracking-wider">Admin</span>
                                @elseif ($user->role === 'customer')
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full border border-blue-100 uppercase tracking-wider">Customer</span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full border border-slate-200 uppercase tracking-wider">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->is_locked)
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-bold rounded-full border border-rose-100 inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        Bị khóa
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100 inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                        Hoạt động
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Toggle Lock/Unlock -->
                                    <form method="POST" action="{{ route('admin.users.toggle-lock', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors {{ $user->is_locked ? 'text-emerald-600 hover:border-emerald-200' : 'text-amber-600 hover:border-amber-200' }}"
                                            title="{{ $user->is_locked ? 'Mở khóa tài khoản' : 'Khóa tài khoản' }}"
                                            {{ auth()->id() === $user->id ? 'disabled class=opacity-50' : '' }}
                                        >
                                            @if ($user->is_locked)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Edit -->
                                    <a 
                                        href="{{ route('admin.users.edit', $user->id) }}" 
                                        class="p-1.5 rounded-lg border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-slate-50 transition-colors"
                                        title="Chỉnh sửa thông tin"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không? Hành động này không thể hoàn tác.')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 rounded-lg border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-slate-50 transition-colors"
                                            title="Xóa tài khoản"
                                            {{ auth()->id() === $user->id ? 'disabled class=opacity-50' : '' }}
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Không tìm thấy tài khoản nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
