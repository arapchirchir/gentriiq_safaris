<?php

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('guests can view the staff login form', function () {
    $this->get('/login')->assertSee('Staff sign in')->assertDontSee('Register');
});

test('guests are redirected from the staff account', function () {
    $this->get('/staff')->assertRedirect('/login');
});

test('existing users can sign in', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    $response->assertRedirect('/staff');
    $this->assertAuthenticatedAs($user);
});

test('invalid credentials are rejected', function () {
    $user = User::factory()->create();

    $response = $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'incorrect']);

    $response->assertRedirect('/login')->assertSessionHasErrors(['email' => __('auth.failed')]);
    $this->assertGuest();
});

test('login requires an email and password', function () {
    $response = $this->from('/login')->post('/login', []);

    $response->assertSessionHasErrors(['email', 'password']);
    $this->assertGuest();
});

test('public registration is unavailable', function (string $method) {
    $response = $this->{$method}('/register', []);

    $response->assertNotFound();
    $this->assertDatabaseCount('users', 0);
})->with(['get', 'post']);

test('staff account escapes the signed in users name', function () {
    $user = User::factory()->create(['name' => '<script>alert(1)</script>']);

    $response = $this->actingAs($user)->get('/staff');

    $response->assertSee($user->name)->assertDontSee($user->name, false)->assertSee('Sign out');
});

test('signed in users can log out', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});

test('repeated login attempts are throttled', function () {
    $this->freezeTime();
    $user = User::factory()->create();
    for ($attempt = 0; $attempt < 5; $attempt++) {
        $this->post('/login', ['email' => $user->email, 'password' => 'incorrect']);
    }

    $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    $response->assertTooManyRequests();
    $this->assertGuest();
});

test('signed in users can view password confirmation', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/user/confirm-password')->assertSee('Confirm your password');
});

test('admin user seeder provisions default staff accounts with correct roles', function () {
    $this->seed(AdminUserSeeder::class);

    $admin = User::where('email', 'admin@gentriiqsafaris.co.ke')->first();
    $sales = User::where('email', 'sales@gentriiqsafaris.co.ke')->first();
    $editor = User::where('email', 'editor@gentriiqsafaris.co.ke')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->isSuperAdmin())->toBeTrue()
        ->and($admin->isAdmin())->toBeTrue()
        ->and($admin->role_label)->toBe('Super Administrator');

    expect($sales)->not->toBeNull()
        ->and($sales->isSales())->toBeTrue()
        ->and($sales->isAdmin())->toBeFalse()
        ->and($sales->role_label)->toBe('Safari Sales Specialist');

    expect($editor)->not->toBeNull()
        ->and($editor->isEditor())->toBeTrue()
        ->and($editor->isAdmin())->toBeFalse()
        ->and($editor->role_label)->toBe('Content Editor');
});
