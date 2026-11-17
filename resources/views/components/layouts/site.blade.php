@props([
    'title' => null,
    'description' => 'Instituto de Idioma y Cultura China en México, A.C.: cursos de chino mandarín, certificaciones HSK, becas y eventos culturales.',
    'image' => '/img/og/iicc-og.jpg',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ filled($title) ? __($title).' - '.config('app.name') : config('app.name') }}</title>

        <meta name="description" content="{{ $description }}">
        <link rel="canonical" href="{{ url()->current() }}">

        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:locale" content="es_MX">
        <meta property="og:title" content="{{ filled($title) ? __($title).' - '.config('app.name') : config('app.name') }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ url($image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta name="twitter:card" content="summary_large_image">

        @include('partials.favicons')

        @fonts

        @vite(['resources/css/site.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-dvh bg-white font-sans text-neutral-900 antialiased">
        <x-site.header />

        <main id="swup" class="transition-fade pt-20">
            {{ $slot }}
        </main>

        <x-site.footer />

        @livewireScripts
    </body>
</html>
