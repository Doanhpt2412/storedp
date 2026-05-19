<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage-users');

        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-users');

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-users');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'customer', 'user'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_locked' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('manage-users');

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('manage-users');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'customer', 'user'])],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('manage-users');

        // Prevent self deletion
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công!');
    }

    /**
     * Lock or Unlock the specified user.
     */
    public function toggleLock(User $user)
    {
        Gate::authorize('manage-users');

        // Prevent self locking
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $user->update([
            'is_locked' => !$user->is_locked
        ]);

        $statusMessage = $user->is_locked ? 'Đã khóa tài khoản thành công!' : 'Đã mở khóa tài khoản thành công!';

        return redirect()->route('admin.users.index')->with('success', $statusMessage);
    }
}
