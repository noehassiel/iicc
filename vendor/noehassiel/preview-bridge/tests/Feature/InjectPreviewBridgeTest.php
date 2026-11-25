<?php

use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::middleware('web')->group(function () {
        Route::get('/page', fn () => response('<html><body><h1>Inicio</h1></body></html>')->header('X-Frame-Options', 'SAMEORIGIN'));
        Route::get('/json', fn () => ['ok' => true]);
        Route::get('/strict', fn () => response('<html><body></body></html>')->header('Content-Security-Policy', "default-src 'self'; frame-ancestors 'none'"));
    });
});

test('it does nothing while disabled', function () {
    config(['preview-bridge.enabled' => false]);

    $this->get('/page')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeaderMissing('Content-Security-Policy')
        ->assertDontSee('nh:navigate', false);
});

test('when enabled only the portal can frame the page and the script reports to it', function () {
    config(['preview-bridge.enabled' => true]);

    $this->get('/page')
        ->assertHeaderMissing('X-Frame-Options')
        ->assertHeader('Content-Security-Policy', "frame-ancestors 'self' https://portal.test")
        ->assertSee('<script data-portal="https://portal.test">', false)
        ->assertSee('nh:navigate', false);
});

test('an existing frame-ancestors rule is replaced, the rest of the policy kept', function () {
    config(['preview-bridge.enabled' => true]);

    $this->get('/strict')->assertHeader('Content-Security-Policy', "default-src 'self'; frame-ancestors 'self' https://portal.test");
});

test('json and livewire updates are never touched', function () {
    config(['preview-bridge.enabled' => true]);

    $this->get('/json')->assertExactJson(['ok' => true]);
    $this->get('/page', ['X-Livewire' => 'true'])->assertDontSee('nh:navigate', false);
});
