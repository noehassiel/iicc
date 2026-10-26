<?php

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
