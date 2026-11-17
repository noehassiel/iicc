<?php

use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    config(['services.ops.token' => 'test-ops-token']);
});

afterEach(function () {
    Artisan::call('up');
});

test('it rejects requests without a valid token', function () {
    $this->postJson('/_ops/maintenance', ['action' => 'down'])->assertForbidden();

    $this->withToken('wrong')
        ->postJson('/_ops/maintenance', ['action' => 'down'])
        ->assertForbidden();

    expect(app()->isDownForMaintenance())->toBeFalse();
});

test('it is disabled when no token is configured', function () {
    config(['services.ops.token' => null]);

    $this->withToken('')
        ->postJson('/_ops/maintenance', ['action' => 'down'])
        ->assertForbidden();
});

test('it puts the site down and back up', function () {
    $this->withToken('test-ops-token')
        ->postJson('/_ops/maintenance', ['action' => 'down', 'secret' => 'preview-secret-1234'])
        ->assertOk()
        ->assertJson(['status' => 'down']);

    expect(app()->isDownForMaintenance())->toBeTrue();

    $this->get('/')->assertStatus(503)->assertSee('Muy pronto');

    // The endpoint stays reachable while the site is down
    $this->withToken('test-ops-token')
        ->postJson('/_ops/maintenance', ['action' => 'up'])
        ->assertOk()
        ->assertJson(['status' => 'up']);

    expect(app()->isDownForMaintenance())->toBeFalse();
});

test('it validates the action', function () {
    $this->withToken('test-ops-token')
        ->postJson('/_ops/maintenance', ['action' => 'reboot'])
        ->assertUnprocessable();
});
