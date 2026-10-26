@php
    $banner = App\Models\Banner::current();

    $services = [
        ['route' => 'cursos', 'title' => __('Cursos a tu medida'), 'text' => __('A partir de 6 años, presencial o en línea. Clases especializadas y grupos reducidos para una mayor interacción.'), 'image' => __('Foto de clase de cursos'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-motion.webp'],
        ['route' => 'certificaciones', 'title' => __('Certificaciones oficiales'), 'text' => __('Con la guía de profesores expertos, materiales actualizados y simulacros reales, aseguramos tu éxito en los exámenes oficiales.'), 'image' => __('Foto de examen / certificación'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-moss.webp'],
        ['route' => 'becas', 'title' => __('Becas y movilidad'), 'text' => __('Apoyamos tu dedicación con becas de excelencia académica y te brindamos la oportunidad de postular a diversas becas internacionales.'), 'image' => __('Foto de becarios'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-marsh.webp'],
    ];

    $reviews = App\Models\Review::featured();
@endphp

<x-layouts.site>
    {{-- Banner: managed from the admin panel (admin.banner.edit) --}}
    <section class="relative isolate overflow-hidden bg-neutral-900 text-white">
        @if ($banner?->imageUrl())
            <img src="{{ $banner->imageUrl() }}" alt="" class="absolute inset-0 -z-20 size-full object-cover">
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-neutral-950/80 via-neutral-950/40 to-neutral-950/20"></div>
        @else
            <div class="absolute inset-0 -z-10 bg-neutral-700"></div>
        @endif

        <div class="mx-auto flex min-h-[80dvh] max-w-7xl flex-col justify-end gap-6 px-4 py-16 lg:justify-center">
            <h1 class="max-w-2xl text-4xl font-semibold text-balance sm:text-5xl">{{ $banner?->localized('title') ?? __('Instituto de Idioma y Cultura China en México') }}</h1>
            @if ($banner?->localized('subtitle'))
                <p class="max-w-2xl text-xl text-white/80">{{ $banner->localized('subtitle') }}</p>
            @endif
            @if ($banner?->button_url)
                <a href="{{ $banner->button_url }}" class="inline-flex items-center justify-center gap-2 self-start rounded-full bg-brand-green px-6 py-3 font-semibold text-white transition hover:brightness-110">
                    {{ $banner->localized('button_label') }}
                </a>
            @else
                <x-site.whatsapp-button :message="__('Hola, quiero información sobre los cursos de chino.')" class="self-start">
                    {{ $banner?->localized('button_label') ?? __('Comienza ahora') }}
                </x-site.whatsapp-button>
            @endif
        </div>
    </section>

    <section class="stacked-scroll-panel-2" data-stacked-scroll-panel-2 data-theme="light" aria-label="{{ __('Nuestros servicios') }}">
        <div class="stack" data-card-stack>
            @foreach ($services as $service)
                <article class="card" data-card>
                    <div class="card-content">
                        <h2 class="font-semibold uppercase">{{ $service['title'] }}</h2>
                        <div class="flex flex-col gap-6">
                            <p>{{ $service['text'] }}</p>
                            <a href="{{ route($service['route']) }}" class="self-start font-semibold">{{ __('Leer más →') }}</a>
                        </div>
                    </div>

                    {{-- Imagen: {{ $service['image'] }} (placeholder temporal) --}}
                    <div class="media" aria-hidden="true">
                        <img src="{{ $service['placeholder'] }}" alt="" loading="lazy" />
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Google reviews: managed from the admin panel (admin.reviews.*) --}}
    @if ($reviews->isNotEmpty())
    <section class="bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Reseñas de Google')">{{ __('4.5 ★ · +20 reseñas') }}</x-site.section-heading>

            <div class="testimonial-05 mt-8" data-testimonials data-autoplay="6000">
                <div class="progress" aria-hidden="true">
                    <span data-progress></span>
                </div>

                <div class="carousel">
                    <nav class="controls" aria-label="{{ __('Controles de reseñas') }}">
                        <button type="button" data-previous aria-label="{{ __('Reseña anterior') }}" aria-controls="reviews-stage">
                            <span class="arrow" aria-hidden="true"><svg width="18" height="16" viewBox="0 0 18 16" fill="none"><path d="M0 8.88482V6.76069L13.2244 6.78353L12.8362 6.3724L7.94837 1.50745L9.41014 0L17.2672 7.81133L9.43298 15.6455L7.94837 14.1381L13.2473 8.86198L0 8.88482Z" fill="currentColor"/></svg><svg width="18" height="16" viewBox="0 0 18 16" fill="none"><path d="M0 8.88482V6.76069L13.2244 6.78353L12.8362 6.3724L7.94837 1.50745L9.41014 0L17.2672 7.81133L9.43298 15.6455L7.94837 14.1381L13.2473 8.86198L0 8.88482Z" fill="currentColor"/></svg></span>
                        </button>
                        <button type="button" data-next aria-label="{{ __('Reseña siguiente') }}" aria-controls="reviews-stage">
                            <span class="arrow" aria-hidden="true"><svg width="18" height="16" viewBox="0 0 18 16" fill="none"><path d="M0 8.88482V6.76069L13.2244 6.78353L12.8362 6.3724L7.94837 1.50745L9.41014 0L17.2672 7.81133L9.43298 15.6455L7.94837 14.1381L13.2473 8.86198L0 8.88482Z" fill="currentColor"/></svg><svg width="18" height="16" viewBox="0 0 18 16" fill="none"><path d="M0 8.88482V6.76069L13.2244 6.78353L12.8362 6.3724L7.94837 1.50745L9.41014 0L17.2672 7.81133L9.43298 15.6455L7.94837 14.1381L13.2473 8.86198L0 8.88482Z" fill="currentColor"/></svg></span>
                        </button>
                    </nav>

                    <div class="stage" id="reviews-stage">
                        @foreach ($reviews as $review)
                            <article @class(['slide', 'is-active' => $loop->first]) data-slide aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                                <blockquote class="quote">
                                    <p data-quote>“{{ $review->text }}”</p>
                                </blockquote>

                                <footer class="person">
                                    <div class="avatar" data-avatar aria-hidden="true">{{ mb_substr($review->author, 0, 1) }}</div>
                                    <div class="identity">
                                        <p data-person-line>{{ $review->author }}</p>
                                        <p class="role" data-person-line><span class="text-brand-orange" aria-hidden="true">{{ str_repeat('★', $review->rating) }}</span><span class="sr-only">{{ __(':rating de 5 estrellas', ['rating' => $review->rating]) }}</span> {{ __('Reseña de Google') }}</p>
                                    </div>
                                </footer>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="relative isolate overflow-hidden px-4 py-20 text-white">
        {{-- Imagen: foto del patio escolar desenfocada (2:1) --}}
        <div class="absolute inset-0 -z-10 bg-brand-blue"></div>

        <div class="mx-auto flex max-w-7xl flex-col items-start gap-4">
            <h2 class="text-3xl font-semibold sm:text-4xl">{{ __('¿Preguntas?') }}</h2>
            <p class="text-lg text-white/90">{{ __('Estamos listos para ayudarte.') }}<br>{{ __('¡Escríbenos y da el primer paso hoy!') }}</p>
            <x-site.whatsapp-button :message="__('Hola, tengo una pregunta.')" class="mt-2">
                {{ __('Escríbenos ahora') }}
            </x-site.whatsapp-button>
        </div>
    </section>
</x-layouts.site>
