@php
    $menu = [
        ['href' => route('home'), 'label' => __('Inicio')],
        ['href' => route('cursos'), 'label' => __('Cursos')],
        ['href' => route('certificaciones'), 'label' => __('Certificaciones')],
        ['href' => route('becas'), 'label' => __('Becas')],
        ['href' => route('otros-servicios'), 'label' => __('Otros Servicios')],
        ['href' => route('eventos.index'), 'label' => __('Eventos')],
        ['href' => route('nosotros'), 'label' => __('Nosotros')],
        ['href' => route('contacto'), 'label' => __('Contacto')],
    ];

    $socials = [
        ['href' => config('site.facebook'), 'label' => 'Facebook'],
        ['href' => config('site.instagram'), 'label' => 'Instagram'],
        ['href' => config('site.youtube'), 'label' => 'YouTube'],
    ];

    $link = 'rounded-sm transition-opacity duration-150 ease-out hover:opacity-70 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white';
    $label = 'text-sm text-white/65';
@endphp

<footer class="bg-white px-4 pt-4 pb-4">
    <div class="rounded-3xl bg-brand-blue-deep px-6 pt-10 pb-6 text-white sm:px-10 sm:pt-14 lg:px-14 lg:pt-16">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <h2 class="max-w-[20ch] text-2xl leading-tight font-semibold text-balance sm:text-4xl">Instituto de Idioma y Cultura China en México, A.C.</h2>

                <x-site.whatsapp-button
                    class="self-start focus-visible:outline-white! lg:self-auto"
                    :message="__('Hola, quisiera información sobre los cursos de IICC.')"
                >{{ __('¡Contáctanos por WhatsApp!') }}</x-site.whatsapp-button>
            </div>

            <div class="mt-14 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:mt-20 lg:grid-cols-[1.2fr_1.1fr_auto_auto] lg:gap-x-14">
                <nav aria-labelledby="footer-menu">
                    <h3 id="footer-menu" class="{{ $label }}">{{ __('Menú principal') }}</h3>
                    <ul class="mt-4 grid grid-cols-2 gap-x-8 gap-y-2.5">
                        @foreach ($menu as $item)
                            <li><a href="{{ $item['href'] }}" class="{{ $link }}">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>

                <div>
                    <h3 class="{{ $label }}">{{ __('Dirección') }}</h3>
                    <a href="{{ config('site.maps') }}" target="_blank" rel="noopener" class="{{ $link }} mt-4 block max-w-[28ch] leading-relaxed">
                        Tomas Alva Edison 92A, Tabacalera, Cuauhtémoc, 06030 Ciudad de México, CDMX
                    </a>
                    <p class="mt-1 text-white/65">{{ __('(cerca del Monumento a la Revolución)') }}</p>
                </div>

                <div>
                    <h3 class="{{ $label }}">{{ __('Horario de atención') }}</h3>
                    <p class="mt-4 leading-relaxed lg:whitespace-nowrap">{{ __('Lunes a Viernes de 09:30 a 17:30') }}</p>
                    <p class="leading-relaxed lg:whitespace-nowrap">{{ __('Sábados de 09:30 a 17:30') }}</p>
                    <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="{{ $link }} mt-2.5 inline-block tabular-nums">{{ config('site.whatsapp_display') }}</a>
                </div>

                <div>
                    <h3 class="{{ $label }}">{{ __('Síguenos en redes sociales') }}</h3>
                    <ul class="mt-4 space-y-2.5">
                        @foreach ($socials as $social)
                            <li>
                                <a href="{{ $social['href'] }}" target="_blank" rel="noopener" class="{{ $link }} group inline-flex items-center gap-2">
                                    {{ $social['label'] }}
                                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="size-3 stroke-current stroke-[1.8] transition-transform duration-200 ease-out group-hover:translate-x-0.5 group-hover:-translate-y-0.5 motion-reduce:transition-none">
                                        <path d="M3 13 13 3M3 3h10v10"></path>
                                    </svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- The institute's Chinese name as the closing mark; each character rises into place as the footer scrolls in --}}
            <p lang="zh-Hant" class="footer-wordmark mt-16 flex justify-between text-[clamp(1.5rem,7vw,6rem)] leading-none lg:mt-24">
                @foreach (mb_str_split('墨西哥中華文化學院') as $character)
                    <span style="--i: {{ $loop->index }}">{{ $character }}</span>
                @endforeach
            </p>

            <div class="mt-8 flex flex-wrap items-baseline justify-between gap-x-8 gap-y-1 text-sm text-white/65">
                <p>IICC &copy; {{ date('Y') }}</p>
                <p>{{ __('Ciudad de México') }}</p>
            </div>
        </div>
    </div>
</footer>
