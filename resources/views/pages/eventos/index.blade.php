{{-- Events: managed from the admin panel (admin.events.*) --}}
@php
    $events = App\Models\Event::query()->with('photos')->latest('date')->get();

    $toCard = fn (App\Models\Event $event) => [
        'slug' => $event->slug,
        'title' => $event->localized('title'),
        'description' => $event->localized('description'),
        'cover' => $event->coverUrl(),
        'year' => $event->date->format('Y'),
    ];

    $culturalActivities = $events->where('category', App\Enums\EventCategory::Cultural)->map($toCard)->values()->all();
    $campusEvents = $events->where('category', App\Enums\EventCategory::Campus)->map($toCard)->values()->all();
    $externalEvents = $events->where('category', App\Enums\EventCategory::Huella)->map($toCard)->values()->all();

    $cardSchemes = [
        ['background' => '#1f4e8c', 'color' => '#ffffff'],
        ['background' => '#163a6b', 'color' => '#ffffff'],
        ['background' => '#4a78b5', 'color' => '#ffffff'],
    ];

    $carouselCards = collect($externalEvents)->values()->map(fn (array $event, int $index) => [
        'title' => (string) $event['year'],
        'description' => $event['title'],
        ...$cardSchemes[$index % count($cardSchemes)],
        'src' => $event['cover'],
        'overlay' => 'rgba(15, 33, 61, 0.5)',
    ]);

    // Modal data, keyed by slug.
    $modalEvents = $events->mapWithKeys(fn (App\Models\Event $event) => [$event->slug => [
        'title' => $event->localized('title'),
        'date' => $event->displayDate(),
        'description' => $event->localized('description') ?? '',
        'photos' => $event->photos->map(fn (App\Models\EventPhoto $photo) => [
            'url' => $photo->url(),
            'caption' => $photo->localized('caption') ?? $event->localized('title'),
        ])->all(),
    ]]);
@endphp

<x-layouts.site title="Eventos">
<div
    x-data="{ events: {{ Js::from($modalEvents) }}, huella: {{ Js::from(collect($externalEvents)->pluck('slug')) }}, current: null, photo: null }"
    x-on:keydown.escape.window="photo !== null ? photo = null : current = null"
    x-effect="document.documentElement.classList.toggle('has-modal-open', current !== null); if (current === null) photo = null"
    x-on:carousel:select="current = huella[$event.detail.index]"
>
    {{-- Hero --}}
    <section class="bg-brand-blue px-4 py-16 text-white sm:py-24">
        <div class="mx-auto max-w-7xl">
            <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Eventos y Vida Cultural') }}</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/85">{{ __('“Vive las tradiciones vivas en nuestras aulas y descubre una trayectoria de más de dos décadas en los espacios culturales de México.”') }}</p>

            <nav class="mt-8 flex flex-wrap gap-3">
                <a href="#actividades-culturales" class="rounded-full border border-white/40 px-4 py-2 text-sm font-medium hover:bg-white/10">{{ __('Actividades Culturales') }}</a>
                <a href="#eventos-en-campus" class="rounded-full border border-white/40 px-4 py-2 text-sm font-medium hover:bg-white/10">{{ __('Eventos en Campus') }}</a>
                <a href="#nuestra-huella" class="rounded-full border border-white/40 px-4 py-2 text-sm font-medium hover:bg-white/10">{{ __('Nuestra Huella') }}</a>
            </nav>
        </div>
    </section>

    {{-- Actividades Culturales --}}
    <section id="actividades-culturales" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Actividades Culturales') }}</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-600">{{ __('El idioma y la cultura van de la mano. Cada mes, nuestros cursos incluyen una actividad vivencial —gastronomía, arte y tradiciones— para vivir el chino más allá de los libros.') }}</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($culturalActivities as $event)
                    <button type="button" x-on:click="current = @js($event['slug'])" class="group block w-full cursor-pointer text-left">
                        @if ($event['cover'])
                            <img src="{{ $event['cover'] }}" alt="" loading="lazy" class="aspect-[4/3] w-full rounded-2xl object-cover">
                        @else
                            <div class="aspect-[4/3] rounded-2xl bg-neutral-100"></div>
                        @endif
                        <h3 class="mt-4 text-lg font-semibold">{{ $event['title'] }}</h3>
                        @if ($event['description'])
                            <p class="mt-1 line-clamp-2 text-neutral-600">{{ $event['description'] }}</p>
                        @endif
                        <span class="mt-2 inline-block font-medium text-brand-blue group-hover:underline">{{ __('Ver fotos') }} →</span>
                    </button>
                @endforeach
            </div>

            <div class="mt-10 flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                <x-site.whatsapp-button :message="__('Hola, quisiera información sobre los cursos de IICC.')">{{ __('Solicita los cursos de IICC') }}</x-site.whatsapp-button>
                <p class="text-neutral-600">{{ __('Síguenos en Instagram / Facebook') }}</p>
            </div>
        </div>
    </section>

    {{-- Eventos en Campus --}}
    <section id="eventos-en-campus" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Eventos en Campus') }}</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-600">{{ __('Las celebraciones anuales que unen a nuestros alumnos, docentes y comunidad educativa.') }}</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($campusEvents as $event)
                    <button type="button" x-on:click="current = @js($event['slug'])" class="group block w-full cursor-pointer text-left">
                        @if ($event['cover'])
                            <img src="{{ $event['cover'] }}" alt="" loading="lazy" class="aspect-[4/3] w-full rounded-2xl object-cover">
                        @else
                            <div class="aspect-[4/3] rounded-2xl bg-neutral-100"></div>
                        @endif
                        <h3 class="mt-4 text-lg font-semibold">{{ $event['title'] }}</h3>
                        @if ($event['description'])
                            <p class="mt-1 line-clamp-2 text-neutral-600">{{ $event['description'] }}</p>
                        @endif
                        <span class="mt-2 inline-block font-medium text-brand-blue group-hover:underline">{{ __('Ver fotos') }} →</span>
                    </button>
                @endforeach
            </div>

            <p class="mt-10 text-neutral-600">{{ __('Síguenos en Instagram / Facebook') }}</p>
        </div>
    </section>

    {{-- Nuestra Huella en México --}}
    <section id="nuestra-huella" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Vinculación Externa')">{{ __('Nuestra Huella en México') }}</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-600">{{ __('Más de 20 años impulsando puentes culturales en el espacio público mediante la coorganización y participación en eventos clave.') }}</p>

        </div>

        {{-- Cylindrical carousel (resources/js/cylindrical-carousel.js). Click a card to open its modal. --}}
        <section
            data-cylindrical-carousel
            class="mt-10"
            aria-label="{{ __('Nuestra Huella en México') }}"
            aria-roledescription="carousel"
            tabindex="0"
            data-cards="{{ $carouselCards->toJson() }}"
            data-error-start="{{ __('El carrusel no pudo iniciar en este navegador.') }}"
            data-error-content="{{ __('No se pudo cargar el contenido del carrusel.') }}"
        >
            <canvas class="scene" data-canvas aria-hidden="true"></canvas>
            <div class="gesture" data-gesture aria-hidden="true"></div>
            <div class="controls" aria-label="{{ __('Controles del carrusel') }}">
                <button type="button" data-previous aria-label="{{ __('Anterior') }}">
                    <svg class="previous" width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true">
                        <path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                    </svg>
                </button>
                <button type="button" data-next aria-label="{{ __('Siguiente') }}">
                    <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true">
                        <path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <p class="accessible" data-announcement aria-live="polite" aria-atomic="true"></p>
            <ul class="accessible" data-card-list></ul>
            <p class="error" data-error hidden>{{ __('No se pudo cargar el carrusel.') }}</p>
        </section>

        <div class="mx-auto max-w-7xl">
            <ul class="sr-only">
                @foreach ($externalEvents as $event)
                    <li><button type="button" x-on:click="current = @js($event['slug'])">{{ $event['year'] }} — {{ $event['title'] }}: {{ __('Ver fotos') }}</button></li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- CTA --}}
    <x-site.cta tone="orange" :message="__('Hola, quisiera participar en las próximas actividades del IICC.')" :button="__('Escríbenos por WhatsApp')">
        <x-slot:heading>{{ __('¿Quieres formar parte de nuestras próximas actividades?') }}</x-slot:heading>
        <x-slot:aside>{{ __('Síguenos en Instagram / Facebook') }}</x-slot:aside>
    </x-site.cta>
    {{-- Event modal: info + gallery --}}
    <template x-teleport="body">
        <div
            x-show="current"
            x-cloak
            x-transition.opacity.duration.300ms
            class="fixed inset-0 z-50 flex items-end justify-center bg-neutral-950/60 backdrop-blur-sm sm:items-center sm:p-6"
            x-on:click.self="current = null"
            role="dialog"
            aria-modal="true"
            x-bind:aria-label="current && events[current].title"
        >
            <template x-if="current">
                <div
                    x-trap.noscroll="current"
                    x-transition:enter="transition duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    x-transition:enter-start="translate-y-8 opacity-0"
                    class="relative max-h-[92svh] w-full max-w-3xl overflow-y-auto rounded-t-3xl bg-white p-6 sm:rounded-3xl sm:p-10"
                >
                    <button type="button" x-on:click="current = null" class="absolute top-4 right-4 grid size-10 cursor-pointer place-items-center rounded-full bg-neutral-100 hover:bg-neutral-200" aria-label="{{ __('Cerrar') }}">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
                    </button>

                    <p class="text-sm font-semibold text-brand-orange" x-text="events[current].date"></p>
                    <h2 class="mt-2 pr-12 text-2xl font-semibold text-balance sm:text-3xl" x-text="events[current].title"></h2>
                    <p class="mt-4 max-w-2xl text-neutral-700" x-text="events[current].description"></p>

                    <h3 class="mt-8 text-lg font-semibold">{{ __('Galería') }}</h3>
                    <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <template x-for="(item, index) in events[current].photos" x-bind:key="item.url">
                            <figure>
                                <button type="button" x-on:click="photo = index" class="group block w-full cursor-zoom-in overflow-hidden rounded-xl" x-bind:aria-label="'{{ __('Ampliar foto') }}: ' + item.caption">
                                    <img x-bind:src="item.url" x-bind:alt="item.caption" loading="lazy" class="aspect-square w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                                </button>
                                <figcaption class="mt-2 text-sm leading-snug text-neutral-600" x-text="item.caption"></figcaption>
                            </figure>
                        </template>
                        {{-- Image: gallery photo placeholders until the CMS provides photos --}}
                        <template x-for="placeholder in (events[current].photos.length ? 0 : 6)" x-bind:key="placeholder">
                            <div class="aspect-square rounded-xl bg-neutral-100"></div>
                        </template>
                    </div>

                    <div class="mt-8">
                        <x-site.whatsapp-button :message="__('Hola, quisiera participar en las próximas actividades del IICC.')">{{ __('¿Quieres formar parte de nuestras próximas actividades?') }}</x-site.whatsapp-button>
                    </div>
                </div>
            </template>
        </div>
    </template>

    {{-- Photo lightbox: enlarged gallery photo with its caption --}}
    <template x-teleport="body">
        <div
            x-show="current && photo !== null"
            x-cloak
            x-transition.opacity.duration.250ms
            class="fixed inset-0 z-[60] flex flex-col items-center justify-center bg-neutral-950/90 p-4 sm:p-10"
            x-on:click.self="photo = null"
            x-on:keydown.arrow-right.window="if (photo !== null) photo = (photo + 1) % events[current].photos.length"
            x-on:keydown.arrow-left.window="if (photo !== null) photo = (photo - 1 + events[current].photos.length) % events[current].photos.length"
            role="dialog"
            aria-modal="true"
            aria-label="{{ __('Foto ampliada') }}"
        >
            <template x-if="current && photo !== null">
                <figure class="flex max-h-full w-full max-w-5xl flex-col items-center" x-trap="photo !== null">
                    <img
                        x-bind:src="events[current].photos[photo].url"
                        x-bind:alt="events[current].photos[photo].caption"
                        x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-start="scale-95 opacity-0"
                        class="max-h-[78svh] w-auto rounded-2xl object-contain"
                    >
                    <figcaption class="mt-4 text-center text-white">
                        <span class="block text-base font-medium sm:text-lg" x-text="events[current].photos[photo].caption"></span>
                        <span class="mt-1 block text-sm text-white/60" x-text="(photo + 1) + ' / ' + events[current].photos.length"></span>
                    </figcaption>
                </figure>
            </template>

            <button type="button" x-on:click="photo = null" class="absolute top-4 right-4 grid size-11 cursor-pointer place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="{{ __('Cerrar') }}">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
            <template x-if="current && events[current].photos.length > 1">
                <div>
                    <button type="button" x-on:click="photo = (photo - 1 + events[current].photos.length) % events[current].photos.length" class="absolute top-1/2 left-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white hover:bg-white/20 sm:left-6" aria-label="{{ __('Anterior') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true" class="rotate-180"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" x-on:click="photo = (photo + 1) % events[current].photos.length" class="absolute top-1/2 right-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white hover:bg-white/20 sm:right-6" aria-label="{{ __('Siguiente') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
</x-layouts.site>
