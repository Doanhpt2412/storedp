<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_password_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'testuser@gmail.com',
        ]);

        $response = $this->withSession(['_token' => 'test-token'])->post('/password/reset', [
            '_token' => 'test-token',
            'email' => $user->email,
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi link khôi phục mật khẩu.');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_email_is_required_when_requesting_password_reset_link(): void
    {
        $response = $this->from('/password/reset')->withSession(['_token' => 'test-token'])->post('/password/reset', [
            '_token' => 'test-token',
            'email' => '',
        ]);

        $response
            ->assertRedirect('/password/reset')
            ->assertSessionHasErrors('email');
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('OldPassword123!'),
        ]);
        $token = Password::broker()->createToken($user);

        $response = $this->withSession(['_token' => 'test-token'])->post('/password/reset/'.$token, [
            '_token' => 'test-token',
            'email' => $user->email,
            'password' => 'NewPass123!',
            'password_confirmation' => 'NewPass123!',
        ]);

        $response
            ->assertRedirect('/login')
            ->assertSessionHas('status', 'Đổi mật khẩu thành công. Bạn có thể đăng nhập bằng mật khẩu mới.');

        $this->assertTrue(Hash::check('NewPass123!', $user->fresh()->password));
        $this->assertFalse(Hash::check('OldPassword123!', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);

        $this->withSession(['_token' => 'test-token'])->post('/login', [
            '_token' => 'test-token',
            'email' => $user->email,
            'password' => 'NewPass123!',
        ])->assertRedirect('/admin');
    }

    public function test_expired_token_cannot_reset_password(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('OldPassword123!'),
        ]);
        $token = Password::broker()->createToken($user);

        DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->update(['created_at' => now()->subMinutes(61)]);

        $response = $this->from('/password/reset/'.$token)->withSession(['_token' => 'test-token'])->post('/password/reset/'.$token, [
            '_token' => 'test-token',
            'email' => $user->email,
            'password' => 'NewPass123!',
            'password_confirmation' => 'NewPass123!',
        ]);

        $response
            ->assertRedirect('/password/reset/'.$token)
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('OldPassword123!', $user->fresh()->password));
    }
}
