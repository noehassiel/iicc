<?php

use App\Models\User;
use Database\Seeders\AdminUserSeeder;

test('guests are redirected to login', function () {
    $this->get(route('admin.events.index'))->assertRedirect(route('login'));
});

test('non admin users are forbidden', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.events.index'))
        ->assertForbidden();
});

test('admins can open every panel screen', function (string $routeName) {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route($routeName))
        ->assertOk();
})->with(['admin.events.index', 'admin.events.create', 'admin.banner.edit']);

test('public registration is disabled', function () {
    $this->get('/register')->assertNotFound();
});

test('the admin seeder creates a verified admin', function () {
    $this->seed(AdminUserSeeder::class);

    $admin = User::firstWhere('email', 'admin@iicc.org.mx');

    expect($admin->is_admin)->toBeTrue()
        ->and($admin->hasVerifiedEmail())->toBeTrue();
});
