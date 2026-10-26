<x-layouts.site title="Contacto">
    {{-- Hero --}}
    <section class="relative px-4 py-16 sm:py-24">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Inicia tu camino en el chino con IICC') }}</h1>
                <p class="mt-4 max-w-xl text-lg text-neutral-600">{{ __('Aprende chino, vive la cultura y conecta con el mundo. Estamos listos para acompañarte en cada paso.') }}</p>
                <x-site.whatsapp-button class="mt-8" :message="__('Hola, quisiera información sobre los cursos de IICC.')">{{ __('¡Contáctanos por WhatsApp!') }}</x-site.whatsapp-button>
            </div>

            {{-- Image: group photo of teachers and students (client to choose) --}}
            <div class="aspect-[4/3] rounded-2xl bg-neutral-100"></div>
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
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-brand-blue">WhatsApp</h2>
                    <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="mt-1 block text-lg font-medium">{{ config('site.whatsapp_display') }}</a>
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
                {{-- Image: embedded Google Map of IICC location --}}
                <div class="aspect-[4/3] rounded-2xl bg-neutral-100"></div>
                <a href="https://maps.google.com/?cid=8245321199947889934" target="_blank" rel="noopener" class="mt-4 inline-flex rounded-full border border-brand-blue px-6 py-3 font-semibold text-brand-blue hover:bg-brand-blue hover:text-white">{{ __('Ver en Google Maps / Cómo llegar') }}</a>
            </div>
        </div>
    </section>

    {{-- Social --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Síguenos en redes sociales') }}</x-site.section-heading>
            {{-- TODO: confirm social URLs (PDF shows handles "IICC" on Facebook and "iiccmex" on Instagram) --}}
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <a href="https://www.facebook.com/" target="_blank" rel="noopener" class="rounded-2xl bg-[#1877F2] px-6 py-5 font-semibold text-white">Facebook · IICC</a>
                <a href="https://www.instagram.com/iiccmex" target="_blank" rel="noopener" class="rounded-2xl bg-gradient-to-r from-[#F58529] via-[#DD2A7B] to-[#8134AF] px-6 py-5 font-semibold text-white">Instagram · iiccmex</a>
                <a href="https://www.youtube.com/" target="_blank" rel="noopener" class="rounded-2xl bg-[#FF0000] px-6 py-5 font-semibold text-white">YouTube</a>
            </div>
        </div>
    </section>
</x-layouts.site>
