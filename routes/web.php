<?php

use App\Livewire\Admin;
use Illuminate\Support\Facades\Route;

Route::get('idioma/{locale}', function (string $locale) {
    abort_unless(array_key_exists($locale, config('site.locales')), 404);

    session(['locale' => $locale]);

    return redirect()->back(fallback: route('home'));
})->name('locale.switch');

Route::view('/', 'pages.home')->name('home');
Route::view('cursos', 'pages.cursos')->name('cursos');
Route::view('certificaciones', 'pages.certificaciones')->name('certificaciones');
Route::view('becas', 'pages.becas')->name('becas');
Route::view('otros-servicios', 'pages.otros-servicios')->name('otros-servicios');
Route::view('nosotros', 'pages.nosotros')->name('nosotros');
Route::view('contacto', 'pages.contacto')->name('contacto');

Route::view('eventos', 'pages.eventos.index')->name('eventos.index');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', 'admin/eventos')->name('home');
    Route::livewire('banners', Admin\Banners\Index::class)->name('banners.index');
    Route::livewire('banners/crear', Admin\Banners\Form::class)->name('banners.create');
    Route::livewire('banners/{banner}', Admin\Banners\Form::class)->name('banners.edit');
    Route::livewire('eventos', Admin\Events\Index::class)->name('events.index');
    Route::livewire('eventos/crear', Admin\Events\Form::class)->name('events.create');
    Route::livewire('eventos/{event}', Admin\Events\Form::class)->name('events.edit');
    Route::livewire('resenas', Admin\Reviews\Index::class)->name('reviews.index');
    Route::livewire('resenas/crear', Admin\Reviews\Form::class)->name('reviews.create');
    Route::livewire('resenas/{review}', Admin\Reviews\Form::class)->name('reviews.edit');
});

Route::redirect('dashboard', 'admin')->name('dashboard');

require __DIR__.'/settings.php';
