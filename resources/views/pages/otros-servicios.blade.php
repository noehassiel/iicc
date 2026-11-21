@php
    /** @var list<array{src: string, alt: string}> $summer */
    $summer = array_map(fn (string $photo): array => [
        'src' => asset("img/other/{$photo}.webp"),
        'alt' => __('Curso de Verano en IICC'),
    ], ['CursodeVerano', 'CursodeVerano2', 'CursodeVerano3', 'CursodeVerano4']);
@endphp

<x-layouts.site title="Otros Servicios">
<div
    x-data="{
        gallery: {{ Js::from(['verano' => $summer]) }},
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
    {{-- Hero --}}
    <section class="px-4 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl">
            <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Otros Servicios en IICC') }}</h1>
            <p class="mt-4 text-lg text-neutral-600">{{ __('Más allá del aula regular') }}</p>

            @php
                $icons = [
                    // graduation cap
                    'formacion' => '<path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/><path d="M22 10v6"/>',
                    // speech bubbles
                    'enlace' => '<path d="M21 15a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2Z"/><path d="M8 9h8M8 13h5"/>',
                    // briefcase
                    'bolsa' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><path d="M3 13h18"/>',
                ];
            @endphp
            <div class="mt-10 grid gap-4 md:grid-cols-3">
                @foreach ([
                    [__('Formación Especial'), [__('Cursos de Verano'), __('Formación Docente')], '#formacion-especial', 'formacion', 'bg-brand-orange/10', 'bg-brand-orange'],
                    [__('Enlace Profesional'), [__('Traducción e Interpretación'), __('Guías de Turismo')], '#enlace-profesional', 'enlace', 'bg-brand-green/10', 'bg-brand-green'],
                    [__('Bolsa de Trabajo'), [__('Oportunidades Laborales'), __('Vinculación con Empresas')], '#bolsa-de-trabajo', 'bolsa', 'bg-brand-blue/10', 'bg-brand-blue'],
                ] as [$title, $items, $anchor, $icon, $surface, $badge])
                    <a href="{{ $anchor }}" class="group flex flex-col rounded-2xl {{ $surface }} p-6 transition hover:-translate-y-0.5 hover:shadow-md">
                        <span class="grid size-12 place-items-center rounded-xl {{ $badge }} text-white" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="size-6">{!! $icons[$icon] !!}</svg>
                        </span>
                        <h2 class="mt-5 text-xl font-semibold">{{ $title }}</h2>
                        <ul class="mt-3 flex-1 space-y-1 text-neutral-700">
                            @foreach ($items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <span class="mt-4 inline-block font-semibold text-brand-blue">{{ __('Leer más') }} <span class="inline-block transition-transform group-hover:translate-x-1">&rarr;</span></span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cursos de verano --}}
    <section id="formacion-especial" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Formación Especial')">{{ __('Cursos de Verano en IICC') }}</x-site.section-heading>

            <ul class="mt-6 flex flex-wrap gap-2 text-sm font-medium">
                <li class="rounded-full bg-white px-4 py-2 shadow-sm">{{ __('3 a 4 semanas') }}</li>
                <li class="rounded-full bg-white px-4 py-2 shadow-sm">{{ __('Lun a Vie · 3 hrs diarias') }}</li>
                <li class="rounded-full bg-white px-4 py-2 shadow-sm">{{ __('Niños y Jóvenes') }}</li>
            </ul>

            <div class="mt-8 grid gap-8 md:grid-cols-2 md:items-center">
                <dl class="grid gap-3">
                    @foreach ([
                        [__('Aprendizaje Lúdico:'), __('Canciones, juegos tradicionales y dinámicas para aprender de forma natural.'), 'border-brand-orange'],
                        [__('Pinyin y Escritura Básica:'), __('Fundamentos fonéticos, trazos iniciales y talleres culturales vivenciales.'), 'border-brand-green'],
                        [__('Continuidad Escolar:'), __('Pase directo para integrarse a nuestras clases regulares al finalizar el curso.'), 'border-brand-blue'],
                    ] as [$term, $detail, $accent])
                        <div class="rounded-2xl border-l-4 {{ $accent }} bg-white p-5 shadow-sm">
                            <dt class="font-semibold">{{ $term }}</dt>
                            <dd class="mt-1 text-neutral-600">{{ $detail }}</dd>
                        </div>
                    @endforeach
                </dl>
                <button type="button" x-on:click="show('verano', 0)" class="group block w-full cursor-zoom-in overflow-hidden rounded-2xl bg-neutral-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}">
                    <img src="{{ $summer[0]['src'] }}" alt="{{ __('Galería: Momentos de Nuestro Curso de Verano en 2026') }}" width="1280" height="960" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                </button>
            </div>

            <x-site.whatsapp-button :message="__('Hola, me gustaría conocer fechas y costos del curso de verano.')" class="mt-8">{{ __('Solicita fechas y costos a IICC') }}</x-site.whatsapp-button>

            <h3 class="mt-12 text-center text-lg font-semibold">{{ __('Galería: Momentos de Nuestro Curso de Verano en 2026') }}</h3>
            <div class="mt-4 grid grid-cols-2 gap-3 lg:grid-cols-4">
                @foreach ($summer as $photo)
                    <button type="button" x-on:click="show('verano', {{ $loop->index }})" class="group block cursor-zoom-in overflow-hidden rounded-xl bg-neutral-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}">
                        <img src="{{ $photo['src'] }}" alt="" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                    </button>
                @endforeach
            </div>
            <p class="mt-4 text-center italic text-neutral-600">"{{ __('Descubre cómo nuestros estudiantes viven y disfrutan el idioma chino en IICC') }}"</p>
        </div>
    </section>

    {{-- Formación docente --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Formación Especial')">{{ __('Formación Docente y Oportunidades de Pasantía') }}</x-site.section-heading>
            <p class="mt-3 max-w-6xl text-pretty text-neutral-600">{{ __('Capacitamos a los futuros profesionales de la enseñanza del chino mandarín con metodología práctica y experiencia real en el aula.') }}</p>

            <div class="mt-8 grid gap-4 md:grid-cols-[1fr_auto_1fr_auto_1fr] md:items-stretch">
                @foreach ([
                    [__('Materiales y Planificación'), [__('Recursos completos'), __('Diseño de clase')]],
                    [__('Observación de Clases'), [__('Observación guiada'), __('Gestión de aula')]],
                    [__('Prácticas y Suplencias'), [__('Práctica y suplencias'), __('Bolsa de talento')]],
                ] as [$title, $items])
                    @unless ($loop->first)
                        <span class="grid place-items-center text-brand-orange" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="size-7 rotate-90 md:rotate-0"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    @endunless
                    <article class="rounded-2xl border p-6">
                        <p class="text-sm font-semibold text-brand-orange">{{ __('Etapa') }} {{ $loop->iteration }}</p>
                        <h3 class="mt-1 font-semibold">{{ $title }}</h3>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            @foreach ($items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>

            <x-site.whatsapp-button :message="__('Hola, me gustaría recibir informes sobre la formación docente.')" class="mt-8">{{ __('¡Solicita informes sobre la formación!') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Enlace profesional --}}
    <section id="enlace-profesional" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Enlace Profesional')">{{ __('Servicios de Vinculación y Enlace Profesional') }}</x-site.section-heading>
            <p class="mt-3 max-w-6xl text-pretty text-neutral-600">{{ __('Conectamos tus requerimientos con especialistas bilingües (chino-español) calificados de nuestra red.') }}</p>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('Traducción e Interpretación') }}</h3>
                    <ul class="mt-4 space-y-2 text-neutral-600">
                        <li><strong class="text-neutral-900">{{ __('Traducción:') }}</strong> {{ __('Documentos comerciales, técnicos y académicos.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Interpretación:') }}</strong> {{ __('Reuniones de negocios, ferias y conferencias.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Enlace:') }}</strong> {{ __('Te conectamos con el especialista ideal según tu proyecto.') }}</li>
                    </ul>
                    <x-site.whatsapp-button :message="__('Hola, necesito un traductor o intérprete chino-español.')" class="mt-6">{{ __('¡Solicitar Traductor o Intérprete!') }}</x-site.whatsapp-button>
                </article>
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('Guías de Turismo Bilingües') }}</h3>
                    <ul class="mt-4 space-y-2 text-neutral-600">
                        <li><strong class="text-neutral-900">{{ __('Recorridos:') }}</strong> {{ __('Rutas turísticas y culturales en chino y español.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Atención:') }}</strong> {{ __('Delegaciones de negocios, visitas oficiales o viajes privados.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Enlace:') }}</strong> {{ __('Contacto directo con guías locales bilingües calificados.') }}</li>
                    </ul>
                    <x-site.whatsapp-button :message="__('Hola, necesito un guía de turismo bilingüe chino-español.')" class="mt-6">{{ __('¡Solicitar Guía Bilingüe!') }}</x-site.whatsapp-button>
                </article>
            </div>

            <p class="mt-6 text-sm text-neutral-500"><strong>{{ __('NOTA:') }}</strong> {{ __('El IICC funge como puente de vinculación; las cotizaciones y acuerdos se gestionan de forma directa con cada especialista independiente.') }}</p>

            <h3 class="mt-12 text-lg font-semibold">{{ __('Nuestra Experiencia en Acción') }}</h3>
            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    __('Presencia profesional y confianza en tu stand.'),
                    __('Atención a compradores y explicación técnica directa.'),
                    __('Interpretación precisa y fluida en negociaciones clave.'),
                ] as $index => $caption)
                    <figure>
                        <a href="{{ asset('img/other/Traduccion'.($index + 1).'.webp') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('img/other/Traduccion'.($index + 1).'.webp') }}" alt="{{ $caption }}" loading="lazy" class="aspect-[4/3] w-full rounded-xl object-cover">
                        </a>
                        <figcaption class="mt-2 text-sm text-neutral-600">{{ $caption }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Bolsa de trabajo --}}
    <section id="bolsa-de-trabajo" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Bolsa de Trabajo')">{{ __('Bolsa de Trabajo y Talento Bilingüe') }}</x-site.section-heading>
            <p class="mt-3 max-w-6xl text-pretty text-neutral-600">{{ __('Conectamos el talento de nuestra comunidad con empresas que requieren el dominio del idioma chino.') }}</p>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <article class="rounded-2xl border p-6">
                    <h3 class="text-xl font-semibold">{{ __('Para Alumnos y Egresados') }}</h3>
                    <ul class="mt-4 space-y-2 text-neutral-600">
                        <li><strong class="text-neutral-900">{{ __('Vacantes y pasantías:') }}</strong> {{ __('Acceso a ofertas laborales reales con empresas que requieren el idioma chino.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Enlace directo:') }}</strong> {{ __('Facilitamos el contacto entre alumnos interesados y las empresas solicitantes.') }}</li>
                    </ul>
                    <x-site.whatsapp-button :message="__('Hola, me gustaría conocer las oportunidades laborales disponibles.')" class="mt-6">{{ __('¡Ver Oportunidades!') }}</x-site.whatsapp-button>
                </article>
                <article class="rounded-2xl border p-6">
                    <h3 class="text-xl font-semibold">{{ __('Para Empresas y Reclutadores') }}</h3>
                    <ul class="mt-4 space-y-2 text-neutral-600">
                        <li><strong class="text-neutral-900">{{ __('Publicación de vacantes:') }}</strong> {{ __('Difunde tus convocatorias directamente a estudiantes evaluados por IICC.') }}</li>
                        <li><strong class="text-neutral-900">{{ __('Talento calificado:') }}</strong> {{ __('Conexión directa con perfiles bilingües (español-chino mandarín).') }}</li>
                    </ul>
                    <x-site.whatsapp-button :message="__('Hola, mi empresa busca talento bilingüe español-chino.')" class="mt-6">{{ __('¡Solicitar Talento Bilingüe!') }}</x-site.whatsapp-button>
                </article>
            </div>

            <p class="mt-6 text-sm text-neutral-500"><strong>{{ __('NOTA:') }}</strong> {{ __('El IICC actúa como canal de difusión y contacto; los procesos de selección y acuerdos laborales competen exclusivamente a la empresa y al postulante.') }}</p>
        </div>
    </section>
    <x-site.lightbox />
</div>
</x-layouts.site>
