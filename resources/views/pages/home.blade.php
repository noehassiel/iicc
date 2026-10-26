@php
    $banner = App\Models\Banner::current()?->load('slides');
    $slides = $banner?->slides ?? collect();

    $services = [
        ['route' => 'cursos', 'title' => __('Cursos a tu medida'), 'text' => __('A partir de 6 años, presencial o en línea. Clases especializadas y grupos reducidos para una mayor interacción.'), 'image' => __('Foto de clase de cursos'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-motion.webp'],
        ['route' => 'certificaciones', 'title' => __('Certificaciones oficiales'), 'text' => __('Con la guía de profesores expertos, materiales actualizados y simulacros reales, aseguramos tu éxito en los exámenes oficiales.'), 'image' => __('Foto de examen / certificación'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-moss.webp'],
        ['route' => 'becas', 'title' => __('Becas y movilidad'), 'text' => __('Apoyamos tu dedicación con becas de excelencia académica y te brindamos la oportunidad de postular a diversas becas internacionales.'), 'image' => __('Foto de becarios'), 'placeholder' => 'https://www.details.so/vault-previews/stacked-scroll-panel-2/media/feature-marsh.webp'],
    ];

    $reviews = App\Models\Review::featured();
@endphp

<x-layouts.site>
    {{-- Banner: managed from the admin panel (admin.banner.edit) --}}
    <div class="hero-page -mt-20">
    <section class="hero-section-01" data-hero-section-01>
        <div class="media" aria-live="polite">
            @forelse ($slides as $slide)
                <div @class(['item', 'active' => $loop->first])>
                    @if ($slide->isVideo())
                        <video src="{{ $slide->url() }}" @if ($slide->thumbnailUrl()) poster="{{ $slide->thumbnailUrl() }}" @endif @if ($loop->first) autoplay preload="auto" @else preload="metadata" @endif muted loop playsinline></video>
                    @else
                        <img src="{{ $slide->url() }}" alt="" @unless ($loop->first) loading="lazy" @endunless>
                    @endif
                </div>
            @empty
                <div class="item active"><div class="fallback"></div></div>
            @endforelse
        </div>

        <div class="content">
            @if ($banner?->localized('subtitle'))
                <p>{{ $banner->localized('subtitle') }}</p>
            @endif

            <div class="headline">
                <h1>{{ $banner?->localized('title') ?? __('Instituto de Idioma y Cultura China en México') }}</h1>

                <div class="cta" data-hero-nav>
                    @if ($banner?->button_url)
                        <a href="{{ $banner->button_url }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-green px-6 py-3 font-semibold text-white transition hover:brightness-110">
                            {{ $banner->localized('button_label') }}
                        </a>
                    @else
                        <x-site.whatsapp-button :message="__('Hola, quiero información sobre los cursos de chino.')">
                            {{ $banner?->localized('button_label') ?? __('Comienza ahora') }}
                        </x-site.whatsapp-button>
                    @endif
                </div>
            </div>

            <span class="divider" aria-hidden="true"></span>

            <div class="thumbs" aria-label="{{ __('Elegir fondo') }}" @if ($slides->count() < 2) data-single aria-hidden="true" @endif>
                @forelse ($slides as $slide)
                    <button @class(['active' => $loop->first]) type="button" aria-label="{{ __('Mostrar fondo :number', ['number' => $loop->iteration]) }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                        @if ($slide->thumbnailUrl())
                            <img src="{{ $slide->thumbnailUrl() }}" alt="" loading="lazy">
                        @else
                            <span class="thumb-fallback" aria-hidden="true">▶</span>
                        @endif
                    </button>
                @empty
                    <button class="active" type="button" tabindex="-1" aria-pressed="true"><span class="thumb-fallback"></span></button>
                @endforelse
            </div>
        </div>

        <div class="loader" aria-hidden="true">
            <div class="panel"></div>
            <div class="panel"></div>

            <div class="progress">
                <span class="line"></span>
                <span class="count">0%</span>
            </div>
        </div>
    </section>

    <div class="hero-section-01-next" data-hero-next>
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
                                    <p data-quote>“{{ $review->localized('text') }}”</p>
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
    </div>
    </div>
</x-layouts.site>
