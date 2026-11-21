<x-layouts.site title="Contacto">
    {{-- Hero --}}
    <section class="relative px-4 py-16 sm:py-24">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Inicia tu camino en el chino con IICC') }}</h1>
                <p class="mt-4 max-w-xl text-lg text-neutral-600">{{ __('Aprende chino, vive la cultura y conecta con el mundo. Estamos listos para acompañarte en cada paso.') }}</p>
                <x-site.whatsapp-button class="mt-8" :message="__('Hola, quisiera información sobre los cursos de IICC.')">{{ __('¡Contáctanos por WhatsApp!') }}</x-site.whatsapp-button>
            </div>

            <img src="{{ asset('img/Inicio/Banner_Inicio_1.jpg') }}" alt="{{ __('Estudiantes de IICC estudiando juntos en la biblioteca') }}" width="1280" height="960" decoding="async" class="aspect-[4/3] w-full rounded-2xl bg-neutral-100 object-cover">
        </div>
    </section>

    {{-- Info --}}
    <section class="bg-neutral-50 px-4 py-16">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-2">
            <div class="space-y-8">
                <div>
                    <p class="font-semibold">Instituto de Idioma y Cultura China en México, A.C.</p>
                    <p lang="zh-Hant" class="text-neutral-600">墨西哥中華文化學院</p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-brand-blue">{{ __('Contacto') }}</h2>
                    <ul class="mt-2 space-y-2 text-lg font-medium">
                        <li>
                            <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 tabular-nums">
                                <x-site.icon.wa class="text-[#25D366]" /><span class="sr-only">WhatsApp:</span>{{ config('site.whatsapp_display') }} <span class="text-sm font-normal text-neutral-500">WhatsApp</span>
                            </a>
                        </li>
                        @foreach (config('site.phones', []) as $phone)
                            <li>
                                <a href="tel:{{ $phone['tel'] }}" class="inline-flex items-center gap-3 tabular-nums">
                                    <x-site.icon.phone class="text-brand-blue" /><span class="sr-only">{{ __('Teléfono') }}:</span>{{ $phone['display'] }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="mailto:{{ config('site.email', 'iiccorgmx@gmail.com') }}" class="inline-flex items-center gap-3">
                                <x-site.icon.mail class="text-brand-blue" /><span class="sr-only">{{ __('Correo electrónico') }}:</span>{{ config('site.email', 'iiccorgmx@gmail.com') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-brand-blue">{{ __('Horario de atención') }}</h2>
                    <p class="mt-1">{{ __('Lunes a Viernes de 09:30 a 17:30') }}</p>
                    <p>{{ __('Sábados de 09:30 a 17:30') }}</p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-brand-blue">{{ __('Dirección') }}</h2>
                    <p class="mt-1">Tomas Alva Edison 92A, Tabacalera, Cuauhtémoc, 06030 Ciudad de México, CDMX</p>
                    <p class="text-neutral-600">{{ __('(cerca del Monumento a la Revolución)') }}</p>
                </div>
            </div>

            <div>
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode('Tomas Alva Edison 92A, Tabacalera, Cuauhtémoc, 06030 Ciudad de México, CDMX') }}&output=embed"
                    title="{{ __('Mapa de ubicación del IICC') }}"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="aspect-[4/3] w-full rounded-2xl border-0 bg-neutral-100"
                ></iframe>
                <a href="{{ config('site.maps') }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-2 rounded-full border border-brand-blue px-6 py-3 font-semibold text-brand-blue hover:bg-brand-blue hover:text-white">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="size-5" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/></svg>
                    {{ __('Ver en Google Maps / Cómo llegar') }}
                </a>
            </div>
        </div>
    </section>

    {{-- Social --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Síguenos en redes sociales') }}</x-site.section-heading>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['https://wa.me/'.config('site.whatsapp'), 'WhatsApp', config('site.whatsapp_display'), 'bg-[#25D366]', '<path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.05-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.08 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35M12.04 21.5a9.4 9.4 0 0 1-4.8-1.31l-.34-.2-3.57.93.95-3.48-.22-.36a9.43 9.43 0 0 1-1.45-5.03c0-5.2 4.24-9.44 9.45-9.44a9.44 9.44 0 0 1 0 18.89m8.04-17.49A11.3 11.3 0 0 0 .67 12.04c0 2 .52 3.96 1.52 5.68L.57 23.33l5.73-1.5a11.3 11.3 0 0 0 5.44 1.39c6.26 0 11.36-5.1 11.37-11.37 0-3.04-1.18-5.89-3.33-8.04"/>'],
                    [config('site.facebook'), 'Facebook', 'Instituto de Idioma y Cultura China en México A.C.', 'bg-[#1877F2]', '<path d="M14 8.5V6.8c0-.8.2-1.3 1.4-1.3H17V2.3A22 22 0 0 0 14.6 2C12.2 2 10.6 3.5 10.6 6.2v2.3H8v3.6h2.6V22H14v-9.9h2.7l.4-3.6Z"/>'],
                    [config('site.instagram'), 'Instagram', 'iiccmex', 'bg-linear-to-br from-[#F58529] via-[#DD2A7B] to-[#8134AF]', '<path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0 8.2a3.2 3.2 0 1 1 0-6.4 3.2 3.2 0 0 1 0 6.4ZM17.3 5.5a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4ZM12 3.8c2.7 0 3 0 4 .06 2.7.12 4 1.42 4.1 4.1.06 1.06.07 1.37.07 4.04s0 3-.07 4.04c-.12 2.7-1.4 4-4.1 4.1-1.06.06-1.37.07-4 .07s-3 0-4.04-.07c-2.7-.12-4-1.42-4.1-4.1C3.8 15 3.8 14.7 3.8 12s0-2.98.07-4.04c.12-2.7 1.42-4 4.1-4.1C9.02 3.8 9.33 3.8 12 3.8ZM12 2c-2.72 0-3.06 0-4.12.06C4.24 2.23 2.23 4.23 2.06 7.88 2 8.94 2 9.28 2 12s0 3.06.06 4.12c.17 3.64 2.18 5.65 5.82 5.82C8.94 22 9.28 22 12 22s3.06 0 4.12-.06c3.63-.17 5.66-2.18 5.82-5.82.06-1.06.06-1.4.06-4.12s0-3.06-.06-4.12c-.16-3.63-2.18-5.65-5.82-5.82C15.06 2 14.72 2 12 2Z"/>'],
                    [config('site.youtube'), 'YouTube', 'IICC 墨西哥中華文化學院', 'bg-[#FF0000]', '<path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8ZM9.7 15V9l5.8 3-5.8 3Z"/>'],
                ] as [$href, $network, $handle, $color, $icon])
                    <a href="{{ $href }}" target="_blank" rel="noopener" class="group flex items-center gap-4 rounded-2xl border border-neutral-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                        <span class="grid size-14 shrink-0 place-items-center rounded-full {{ $color }} text-white" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="size-7">{!! $icon !!}</svg>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm text-neutral-500">{{ $network }}</span>
                            <span class="block font-semibold text-pretty">{{ $handle }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.site>
