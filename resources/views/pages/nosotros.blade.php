@php
    $staff = [
        ['name' => 'Grace Chang', 'hanzi' => '張清雲', 'role' => __('Directora General del IICC'), 'image' => 'grace-chang'],
        ['name' => 'Jeymmi Rivera', 'hanzi' => null, 'role' => __('Coordinación y Admisiones'), 'image' => 'jeymmi-rivera'],
        ['name' => 'Juan Barrera', 'hanzi' => null, 'role' => __('Seguridad y Atención en Campus'), 'image' => 'juan-barrera'],
    ];

    // [file slug in img/Nosotros/maestros, Latin name, Traditional Chinese name, years teaching (null = not provided yet)]
    $teachers = [
        ['monica-qiu', 'Monica Qiu', '邱聯慈', null],
        ['nora-wang', 'Nora Wang', '王鐸', 11],
        ['becky-cheng', 'Becky Cheng', '鄭雅方', null],
        ['irene-chang', 'Irene Chang', '張萌', null],
        ['jodie-chen', 'Jodie Chen', '陳思伃', null],
        ['min-yi-chen', 'Min Yi Chen', '陳敏瑜', null],
        ['zoey-qiu-mei', 'Zoey Qiu Mei', '邱梅盈熙', null],
        ['ruby-her', 'Ruby Her', '賀立汝', 1],
        ['diana-chang', 'Diana Chang', '常翔', null],
        ['jose-castro', 'José Antonio Castro Gutiérrez', null, null],
        ['debby-lin', 'Debby Lin', '林霈芸', null],
        ['melissa-feng', 'Melissa Feng', '馮昊', 6],
    ];

    $achievements = [
        ['value' => 12000, 'label' => __('Alumnos formados en el IICC desde 2003')],
        ['value' => 500, 'label' => __('Alumnos certificados en TOCFL y HSK')],
        ['value' => 150, 'label' => __('Niños y jóvenes certificados en YCT y CCCC')],
    ];

    $spaces = [
        ['key' => 'afuera', 'cover' => 1, 'photos' => ['exterior-puerta-principal', 'exterior-patio-1', 'exterior-patio-2', 'exterior-cocina-sanitario'], 'title' => __('Planta Baja (afuera)'), 'text' => __('Un amplio patio al aire libre donde se celebran talleres culturales mensuales y eventos comunitarios; el lugar de juego favorito durante el recreo. Cuenta además con cocina para talleres y sanitarios para hombres al fondo.')],
        ['key' => 'interior', 'cover' => 0, 'photos' => ['interior-recepcion', 'interior-direccion', 'interior-aula-1', 'interior-aula-2', 'interior-pasillo', 'interior-biblioteca'], 'title' => __('Planta Baja (interior)'), 'text' => __('La planta baja alberga dos cómodas aulas de clase, el área de recepción y secretaría para atención a alumnos, y la oficina de dirección general.')],
        ['key' => 'piso1', 'cover' => 0, 'photos' => ['piso1-aula-ninos-1', 'piso1-aula-ninos-2', 'piso1-aula-ninos-3', 'piso1-aula-ninos-4', 'piso1-aula-1-1', 'piso1-aula-1-2', 'piso1-aula-2', 'piso1-aula-3-1', 'piso1-aula-3-2', 'piso1-pasillo', 'piso1-sanitario-1', 'piso1-sanitario-2'], 'title' => __('Primer Piso'), 'text' => __('Espacio de aulas múltiples: cuenta con un gran salón interactivo para cursos infantiles y campamentos, tres aulas adicionales y sanitarios para damas.')],
    ];

    // Caption per photo, named after the space it shows.
    $captions = [
        'exterior-puerta-principal' => __('Entrada principal'),
        'exterior-patio-1' => __('Patio'),
        'exterior-patio-2' => __('Patio'),
        'exterior-cocina-sanitario' => __('Cocina y sanitario de hombres'),
        'interior-recepcion' => __('Recepción'),
        'interior-direccion' => __('Dirección general'),
        'interior-aula-1' => __('Aula'),
        'interior-aula-2' => __('Aula'),
        'interior-pasillo' => __('Pasillo'),
        'interior-biblioteca' => __('Biblioteca'),
        'piso1-aula-ninos-1' => __('Salón infantil'),
        'piso1-aula-ninos-2' => __('Salón infantil'),
        'piso1-aula-ninos-3' => __('Salón infantil'),
        'piso1-aula-ninos-4' => __('Salón infantil'),
        'piso1-aula-1-1' => __('Aula 1'),
        'piso1-aula-1-2' => __('Aula 1'),
        'piso1-aula-2' => __('Aula 2'),
        'piso1-aula-3-1' => __('Aula 3'),
        'piso1-aula-3-2' => __('Aula 3'),
        'piso1-pasillo' => __('Pasillo'),
        'piso1-sanitario-1' => __('Sanitario de damas'),
        'piso1-sanitario-2' => __('Sanitario de damas'),
    ];

    /** @var array<string, list<array{src: string, alt: string}>> $gallery */
    $gallery = collect($spaces)
        ->mapWithKeys(fn (array $space): array => [$space['key'] => array_map(fn (string $photo): array => [
            'src' => asset("img/Nosotros/instituto/{$photo}.webp"),
            'alt' => $space['title'].' · '.$captions[$photo],
        ], $space['photos'])])
        ->all();
@endphp

<x-layouts.site title="Nosotros">
<div
    x-data="{
        gallery: {{ Js::from($gallery) }},
        group: null,
        index: 0,
        show(group, index) { this.group = group; this.index = index; },
        close() { this.group = null; },
        step(direction) {
            const total = this.gallery[this.group].length;
            this.index = (this.index + direction + total) % total;
        },
    }"
    x-on:keydown.escape.window="close()"
    x-effect="document.documentElement.classList.toggle('has-modal-open', group !== null)">
    <section class="bg-brand-blue px-4 py-16 text-white">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-semibold uppercase tracking-wider text-white/70">{{ __('Nosotros') }}</p>
            <h1 class="mt-2 max-w-2xl text-3xl font-semibold text-balance sm:text-5xl">{{ __('Enseñando chino mandarín y tendiendo puentes culturales desde 2003') }}</h1>

            <nav class="mt-8 flex flex-wrap gap-3">
                <a href="#historia" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestra Historia') }}</a>
                <a href="#equipo" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestro Equipo') }}</a>
                <a href="#instituto" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestro Entorno') }}</a>
            </nav>
        </div>
    </section>

    <section id="historia" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto grid max-w-7xl gap-8 md:grid-cols-2 md:items-center">
            <div>
                <x-site.section-heading :eyebrow="__('Nuestra Historia')">{{ __('Desde 2003: Mucho más que una escuela') }}</x-site.section-heading>
                <p class="mt-4 text-neutral-700">{{ __('Desde 2003, en el IICC unimos idioma y cultura como un legado vivo. Somos un puente humano para que México descubra la tradición china y un espacio de auténtica reconexión cultural para que la comunidad china en el extranjero se reencuentre con sus raíces.') }}</p>
            </div>
            <img src="{{ asset('img/Nosotros/instituto/exterior-puerta-principal.webp') }}" alt="{{ __('Planta Baja (afuera)') }}" width="1280" height="960" loading="lazy" decoding="async" class="aspect-4/3 w-full rounded-2xl bg-neutral-100 object-cover">
        </div>

        <div class="mx-auto mt-12 grid max-w-7xl gap-4 md:grid-cols-2">
            <div class="rounded-2xl bg-neutral-50 p-6">
                <h3 class="text-lg font-semibold uppercase text-brand-blue">{{ __('Misión') }}</h3>
                <p class="mt-2 text-neutral-700">{{ __('Brindar una enseñanza integral de la lengua y cultura china que sirva como un puente humano, fomentando una educación holística con calidez, calidad y respeto mutuo.') }}</p>
            </div>
            <div class="rounded-2xl bg-neutral-50 p-6">
                <h3 class="text-lg font-semibold uppercase text-brand-blue">{{ __('Visión') }}</h3>
                <p class="mt-2 text-neutral-700">{{ __('Ser la comunidad y el referente educativo más confiable de México en la difusión del idioma chino, formando personas con visión global, empatía intercultural y confianza para comunicarse con el mundo.') }}</p>
            </div>
        </div>
        <div class="mx-auto mt-12 max-w-7xl">
            <h3 class="text-center text-lg font-semibold uppercase text-brand-blue">{{ __('Nuestros valores') }}</h3>
            <ul class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach ([
                    [__('Cuidado y Amor'), '<path d="M12 21s-7.5-4.6-9.5-9.2C1 8.3 3.2 5 6.6 5c2 0 3.4 1.1 4.4 2.5C12 6.1 13.4 5 15.4 5 18.8 5 21 8.3 19.5 11.8 17.5 16.4 12 21 12 21Z"/>'],
                    [__('Calidad de enseñanza'), '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>'],
                    [__('Integridad'), '<path d="M12 3 4 6v6c0 4.5 3.4 8.3 8 9 4.6-.7 8-4.5 8-9V6l-8-3Z"/><path d="m8.5 12 2.5 2.5 4.5-5"/>'],
                    [__('Importancia en Humanidades'), '<path d="M3 21h18M5 21V10M19 21V10M9 21V10M15 21V10M2 10l10-6 10 6H2Z"/>'],
                    [__('Moda Ecológica'), '<path d="M5 19c0-8 6-14 15-14 0 9-6 15-14 15H5v-1Z"/><path d="M5 20 14 11"/>'],
                    [__('Ser Creativo'), '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3.5 10.9c.6.4 1 1.1 1 1.8V16h5v-.3c0-.7.4-1.4 1-1.8A6 6 0 0 0 12 3Z"/>'],
                ] as [$value, $icon])
                    <li class="flex flex-col items-center gap-3 rounded-2xl bg-neutral-50 p-5 text-center">
                        <span class="grid size-12 place-items-center rounded-full bg-white text-brand-orange shadow-sm" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="size-6">{!! $icon !!}</svg>
                        </span>
                        <span class="font-semibold">{{ $value }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="equipo" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Nuestro Equipo')">{{ __('Equipo de Coordinación') }}</x-site.section-heading>
            <p class="mt-4 max-w-6xl text-pretty text-neutral-700">{{ __('Las personas que te acompañan día con día: un equipo dedicado a guiarte, resolver tus dudas y cuidar de tu estancia en el IICC dentro y fuera del aula.') }}</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                @foreach ($staff as $person)
                    <div class="text-center">
                        <img src="{{ asset('img/Nosotros/maestros/'.$person['image'].'.webp') }}" alt="{{ $person['name'] }}" width="600" height="600" loading="lazy" decoding="async" class="aspect-square w-full rounded-2xl bg-neutral-200 object-cover">
                        <p class="mt-3 font-semibold">{{ $person['name'] }}@if ($person['hanzi']) <span class="font-kai font-normal text-neutral-600" lang="zh-Hant">{{ $person['hanzi'] }}</span>@endif</p>
                        <p class="text-sm text-neutral-600">{{ $person['role'] }}</p>
                    </div>
                @endforeach
            </div>

            <x-site.section-heading class="mt-16">{{ __('Conoce a Nuestros Maestros Expertos') }}</x-site.section-heading>
            <p class="mt-4 max-w-6xl text-pretty text-neutral-700">{{ __('Profesores nativos y certificados que combinan experiencia pedagógica con una auténtica pasión por enseñar. Te acompañamos paso a paso con paciencia, dinamismo y grupos reducidos para que hables chino con naturalidad.') }}</p>

            <div class="relative mt-8" x-data="{
                atStart: true,
                atEnd: false,
                update() {
                    const rail = this.$refs.rail;
                    this.atStart = rail.scrollLeft <= 4;
                    this.atEnd = rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 4;
                },
                scrollBy(direction) {
                    const rail = this.$refs.rail;
                    rail.scrollBy({ left: direction * rail.clientWidth * 0.8, behavior: 'smooth' });
                },
            }" x-init="update()">
                <div x-ref="rail" x-on:scroll.debounce.50ms="update()" class="-mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="list" aria-label="{{ __('Conoce a Nuestros Maestros Expertos') }}">
                    @foreach ($teachers as [$slug, $name, $hanzi, $years])
                        <div role="listitem" class="w-2/3 shrink-0 snap-start text-center sm:w-1/4">
                            <img src="{{ asset("img/Nosotros/maestros/{$slug}.webp") }}" alt="{{ $name }}" width="600" height="600" loading="lazy" decoding="async" class="aspect-square w-full rounded-2xl bg-neutral-200 object-cover">
                            <p class="mt-3 font-semibold">{{ $name }}</p>
                            @if ($hanzi)
                                <p class="font-kai text-sm text-neutral-600" lang="zh-Hant">{{ $hanzi }}</p>
                            @endif
                            @if ($years)
                                <p class="mt-2 flex flex-wrap justify-center gap-1.5 text-xs font-medium">
                                    <span class="rounded-full bg-brand-orange/15 px-2.5 py-1 text-neutral-800">{{ __('+:years años', ['years' => $years]) }}</span>
                                    <span class="rounded-full bg-brand-blue/10 px-2.5 py-1 text-brand-blue">{{ __('Presencial y en línea') }}</span>
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex justify-center gap-3">
                    <button type="button" x-on:click="scrollBy(-1)" x-bind:disabled="atStart" class="grid size-11 cursor-pointer place-items-center rounded-full border border-neutral-300 bg-white text-neutral-900 transition hover:border-brand-blue hover:text-brand-blue disabled:cursor-default disabled:opacity-40" aria-label="{{ __('Anterior') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true" class="rotate-180"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" x-on:click="scrollBy(1)" x-bind:disabled="atEnd" class="grid size-11 cursor-pointer place-items-center rounded-full border border-neutral-300 bg-white text-neutral-900 transition hover:border-brand-blue hover:text-brand-blue disabled:cursor-default disabled:opacity-40" aria-label="{{ __('Siguiente') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Nuestros logros') }}</x-site.section-heading>
            <p class="mt-4 text-neutral-700">{{ __('El esfuerzo y la dedicación de nuestra comunidad reflejados en resultados reales.') }}</p>

            <dl class="mt-8 grid gap-6 sm:grid-cols-3">
                @foreach ($achievements as $achievement)
                    <div class="rounded-2xl border border-neutral-200 p-6">
                        <dt class="text-4xl font-semibold text-brand-blue" data-number-flow-stat data-value="{{ $achievement['value'] }}">
                            <number-flow class="nf-number" data-stat-number aria-hidden="true"></number-flow>
                            <span class="sr-only">{{ number_format($achievement['value']) }}+</span>
                        </dt>
                        <dd class="mt-2 text-neutral-600">{{ $achievement['label'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    <section id="instituto" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-8 md:grid-cols-2 md:items-center">
                <div>
                    <x-site.section-heading :eyebrow="__('Nuestro Entorno')">{{ __('Un entorno luminoso y acogedor, pensado para aprender con calma y vivir la cultura.') }}</x-site.section-heading>
                    <p class="mt-4 text-neutral-700">{{ __('Ubicado en el corazón de la Ciudad de México, a pocos pasos del emblemático Monumento a la Revolución, el IICC cuenta con instalaciones cómodas, seguras y luminosas diseñadas para el bienestar de nuestra comunidad. Nuestro campus combina la tranquilidad necesaria para el estudio con espacios abiertos para la convivencia y el intercambio cultural.') }}</p>
                </div>
                <button type="button" x-on:click="show('afuera', 2)" class="group relative block w-full cursor-zoom-in overflow-hidden rounded-2xl bg-neutral-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}: {{ __('Planta Baja (afuera)') }}">
                    <img src="{{ asset('img/Nosotros/instituto/exterior-patio-2.webp') }}" alt="" width="1280" height="960" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                </button>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($spaces as $space)
                    <article class="overflow-hidden rounded-2xl bg-white">
                        <button type="button" x-on:click="show('{{ $space['key'] }}', {{ $space['cover'] }})" class="group relative block w-full cursor-zoom-in overflow-hidden bg-neutral-200 focus-visible:outline-2 focus-visible:-outline-offset-4 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}: {{ $space['title'] }}">
                            <img src="{{ $gallery[$space['key']][$space['cover']]['src'] }}" alt="" width="1280" height="960" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                        </button>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">{{ $space['title'] }}</h3>
                            <p class="mt-2 text-neutral-600">{{ $space['text'] }}</p>
                            <button type="button" x-on:click="show('{{ $space['key'] }}', 0)" class="mt-4 cursor-pointer font-semibold text-brand-blue">{{ __('Ver galería →') }}</button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    <x-site.lightbox />
</div>
</x-layouts.site>
