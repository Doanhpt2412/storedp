<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Phân quyền: Admin có toàn quyền trước tất cả các gate
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        // Quyền quản lý tài khoản (Chỉ admin - được pass qua Gate::before)
        Gate::define('manage-users', function ($user) {
            return $user->isAdmin();
        });

        // Quyền quản lý Sản phẩm (customer được thêm/sửa/xóa)
        Gate::define('manage-products', function ($user) {
            return $user->isCustomer();
        });

        // Quyền bài viết:
        // Cả customer và user đều được thêm
        Gate::define('create-article', function ($user) {
            return $user->isCustomer() || $user->isUser();
        });

        // Chỉ customer mới được sửa bài viết (user không được sửa)
        Gate::define('edit-article', function ($user) {
            return $user->isCustomer();
        });

        // Cả customer và user đều được xóa bài viết
        Gate::define('delete-article', function ($user) {
            return $user->isCustomer() || $user->isUser();
        });
    }
}
