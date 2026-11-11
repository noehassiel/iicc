@php
    $ageGroups = [
        [
            'id' => 'ninos',
            'title' => __('Niños'),
            'ages' => __('6 – 11 años'),
            'focus' => __(
                'Aprende chino de forma lúdico a través de juegos, canciones y manualidades para sentar bases sólidas.',
            ),
        ],
        [
            'id' => 'adolescentes',
            'title' => __('Adolescentes'),
            'ages' => __('12 – 17 años'),
            'focus' => __('Aprende chino de forma natural y comunícate con las bases del idioma chino.'),
        ],
        [
            'id' => 'adultos',
            'title' => __('Adultos'),
            'ages' => __('> 18 años'),
            'focus' => __(
                'Conversación en contextos reales, gramática esencial y preparación para exámenes oficiales.',
            ),
        ],
    ];

    $reasons = [
        [
            'glyph' => '小',
            'title' => __('Grupos reducidos'),
            'body' => __(
                'Máximo 10 personas por clase para garantizar tu participación activa y resolver tus dudas al instante.',
            ),
        ],
        [
            'glyph' => '師',
            'title' => __('Profesores nativos calificados'),
            'body' => __(
                'Aprende de auténticos hablantes nativos. Nuestro equipo docente te guiará con la mejor metodología, corrigiendo tu pronunciación y entonación desde las bases.',
            ),
        ],
        [
            'glyph' => '文',
            'title' => __('Actividades culturales mensuales'),
            'body' => __(
                'Más que un idioma, una experiencia viva. Cada mes realizamos actividades de caligrafía, gastronomía, té y festividades tradicionales chinas. (Son incluidas en los cursos.)',
            ),
        ],
        [
            'glyph' => '獎',
            'title' => __('Becas escolares y a Taiwán o China'),
            'body' => __(
                'Impulsamos tu camino académico. Premiamos tu constancia con becas internas de excelencia y te apoyamos para postular a becas gubernamentales e internacionales.',
            ),
        ],
        [
            'glyph' => '字',
            'title' => __('Caracteres simplificados y tradicionales'),
            'body' => __(
                'Enseñamos ambos sistemas de escritura para que elijas el que mejor se adapte a tus intereses académicos o laborales.',
            ),
        ],
    ];

    /**
     * Class photos per section, in display order. The second value marks screenshots of online classes.
     *
     * @var array<string, array{folder: string, alt: string, shots: list<array{0: int, 1: bool}>}> $photoSets
     */
    $photoSets = [
        'ninos' => ['folder' => 'Claseninos', 'alt' => __('Clase de chino para niños en el IICC'), 'shots' => [[5, false], [2, false], [6, false], [3, false], [4, false], [1, true]]],
        'adolescentes' => ['folder' => 'Claseadolescente', 'alt' => __('Clase de chino para adolescentes en el IICC'), 'shots' => [[3, false], [2, false], [4, false], [5, false], [1, true]]],
        'adultos' => ['folder' => 'Claseadultos', 'alt' => __('Clase de chino para adultos en el IICC'), 'shots' => [[2, false], [3, false], [1, false], [4, true]]],
        'grupal' => ['folder' => 'Clasegrupal', 'alt' => __('Clase grupal de chino en el IICC'), 'shots' => [[3, false], [2, false], [1, true]]],
        'particular' => ['folder' => 'Claseparticular', 'alt' => __('Clase particular de chino en el IICC'), 'shots' => [[2, false], [3, true], [1, true], [4, true]]],
    ];

    /** @var array<string, list<array{src: string, alt: string, online: bool}>> $gallery */
    $gallery = collect($photoSets)
        ->map(fn (array $set): array => array_map(fn (array $shot): array => [
            'src' => asset("img/Cursos/{$set['folder']}/{$set['folder']}{$shot[0]}.jpg"),
            'alt' => $set['alt'],
            'online' => $shot[1],
        ], $set['shots']))
        ->all();

    $ageCovers = ['ninos' => $gallery['ninos'][1], 'adolescentes' => $gallery['adolescentes'][2], 'adultos' => $gallery['adultos'][0]];

    $heroDeck = [$gallery['ninos'][2], $gallery['adolescentes'][1], $gallery['adultos'][1], $gallery['grupal'][0]];
@endphp

<x-layouts.site title="Cursos">
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
    {{-- Hero --}}
    <section class="overflow-x-clip px-4 py-12 sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-balance sm:text-5xl">{{ __('Aprender chino en IICC') }}</h1>
                <p class="mt-4 text-lg text-neutral-600">
                    {{ __('Tenemos más de 20 años de experiencia en la enseñanza de chino mandarín, y ofrecemos varios servicios de cursos para ti.') }}
                </p>
            </div>

            {{-- Photo deck: the top photo is tossed to the back every few seconds; a tap advances it. --}}
            <div
                x-data="{
                    active: 0,
                    leaving: null,
                    total: {{ count($heroDeck) }},
                    timer: null,
                    init() {
                        if (! window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                            this.start();
                        }
                    },
                    start() {
                        this.stop();
                        this.timer = setInterval(() => document.hidden || this.next(), 4500);
                    },
                    stop() { clearInterval(this.timer); this.timer = null; },
                    next() {
                        this.leaving = this.active;
                        this.active = (this.active + 1) % this.total;
                        setTimeout(() => { this.leaving = null; }, 900);
                    },
                    destroy() { this.stop(); },
                }"
                x-on:mouseenter="stop()"
                x-on:mouseleave="init()"
                class="course-deck relative mx-auto w-full max-w-xl px-[6%] py-[5%]"
            >
                <span class="pointer-events-none absolute -top-10 -left-4 font-kai text-[8rem] leading-none text-brand-orange/30 select-none sm:-left-10 sm:text-[11rem]" lang="zh-Hant" aria-hidden="true">學</span>

                <button type="button" x-on:click="next(); stop()" class="relative block aspect-[4/3] w-full cursor-pointer rounded-2xl focus-visible:outline-2 focus-visible:outline-offset-8 focus-visible:outline-brand-blue" aria-label="{{ __('Siguiente') }}">
                    @foreach ($heroDeck as $photo)
                        <img
                            src="{{ $photo['src'] }}"
                            alt="{{ $loop->first ? $photo['alt'] : '' }}"
                            @if (! $loop->first) loading="lazy" @endif
                            data-pos="{{ $loop->index }}"
                            x-bind:data-pos="({{ $loop->index }} - active + total) % total"
                            x-bind:class="leaving === {{ $loop->index }} && 'is-leaving'"
                            class="course-deck-card absolute inset-0 size-full rounded-2xl border-4 border-white object-cover"
                        >
                    @endforeach
                </button>
            </div>
        </div>
    </section>

    {{-- Cursos por edades --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Cursos')">{{ __('Cursos por edades') }}</x-site.section-heading>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach ($ageGroups as $group)
                    <article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm">
                        <a href="#{{ $group['id'] }}" tabindex="-1" aria-hidden="true" class="block overflow-hidden">
                            <img src="{{ $ageCovers[$group['id']]['src'] }}" alt="" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                        </a>
                        <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-xl font-semibold">{{ $group['title'] }}</h3>
                        <p class="text-sm font-medium text-brand-blue">{{ $group['ages'] }}</p>
                        <p class="mt-3 flex-1 text-neutral-600"><span
                                class="font-medium text-neutral-900">{{ __('Enfoque:') }}</span> {{ $group['focus'] }}
                        </p>
                        <a href="#{{ $group['id'] }}"
                            class="mt-4 font-semibold text-brand-blue">{{ __('Lee más →') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Mapa de niveles --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl space-y-12">
            <x-site.section-heading :eyebrow="__('Niveles')">{{ __('Mapa de niveles') }}</x-site.section-heading>

            <a href="/img/Cursos/{{ app()->getLocale() === 'zh_TW' ? 'Mapa-denivelesenchino' : 'Mapa-denivelesenespanol' }}.png"
                target="_blank" rel="noopener" class="block">
                <img src="/img/Cursos/{{ app()->getLocale() === 'zh_TW' ? 'Mapa-denivelesenchino' : 'Mapa-denivelesenespanol' }}.png"
                    alt="{{ __('Mapa de niveles') }}" loading="lazy" class="w-full rounded-2xl border">
            </a>

            <div id="ninos" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Niños (6 – 11 años)') }}</h3>
                <x-site.photo-rail group="ninos" :photos="$gallery['ninos']" class="mt-4 mb-6" />
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Tradicional') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Dirigido a los niños taiwaneses o interesados en caracteres tradicionales.') }}
                            </li>
                            <li>Bopomofo (<span lang="zh-Hant">ㄅㄆㄇ數來寶</span>), Living Mandarin,
                                {{ __('Material personalizado') }}</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Simplificado') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Para los que inician su aprendizaje del chino estándar.') }}</li>
                            <li>{{ __('Chino Fácil, Material personalizado') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-4 rounded-2xl bg-brand-blue/5 p-6">
                    <p class="font-semibold">{{ __('Ruta escolar PEP') }} (<span lang="zh-Hant">人教版</span>):</p>
                    <p class="mt-1 text-neutral-600">
                        {{ __('Diseñada para la continuidad del currículo oficial de China continental a partir de los 10 años. (Más informes en recepción).') }}
                    </p>
                </div>
                <x-site.whatsapp-button class="mt-6"
                    :message="__('Hola, quiero inscribir a mi hijo(a) en el curso de chino para niños.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
            </div>

            <div id="adolescentes" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Adolescentes (12 – 17 años)') }}</h3>
                <x-site.photo-rail group="adolescentes" :photos="$gallery['adolescentes']" class="mt-4 mb-6" />
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Tradicional') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Dirigido a los adolescentes taiwaneses o interesados en caracteres tradicionales.') }}
                            </li>
                            <li>{{ __('Easy Chinese y Material personalizado') }}</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Simplificado') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Para los que inician su aprendizaje del chino estándar.') }}</li>
                            <li>{{ __('Kuaile Hanyu y Material personalizado') }}</li>
                        </ul>
                    </div>
                </div>
                <x-site.whatsapp-button class="mt-6"
                    :message="__('Hola, me interesa el curso de chino para adolescentes.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
            </div>

            <div id="adultos" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Adultos (> 18 años)') }}</h3>
                <x-site.photo-rail group="adultos" :photos="$gallery['adultos']" class="mt-4 mb-6" />
                <div class="mt-4 rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Material: Chino Simplificado') }}</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Para los que inician su aprendizaje del chino estándar.') }}</li>
                        <li>{{ __('Chino Hoy, HSK y Material personalizado') }}</li>
                    </ul>
                </div>
                <div class="mt-4 rounded-2xl bg-brand-blue/5 p-6">
                    <p class="font-semibold">{{ __('Pasos de aprendizaje') }}</p>
                    <p class="mt-1 text-neutral-600">
                        {{ __('Al concluir la serie Chino Hoy, se alcanza el nivel HSK 2, con transición directa a los cursos avanzados a partir de HSK 3.') }}
                    </p>
                </div>
                <x-site.whatsapp-button class="mt-6"
                    :message="__('Hola, me interesa el curso de chino para adultos.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- Clases grupales --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Modalidades')">{{ __('Clases grupales bimestrales') }}</x-site.section-heading>
            <ul class="mt-6 space-y-1 text-neutral-600">
                <li>{{ __('Mínimo 3 alumnos por grupo.') }}</li>
                <li>{{ __('3 horas por semana (Total: 24 horas por bimestre / 8 semanas).') }}</li>
            </ul>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                    <button type="button" x-on:click="show('grupal', 0)" class="course-crossfade group relative block w-full cursor-zoom-in overflow-hidden focus-visible:outline-2 focus-visible:-outline-offset-4 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}: {{ $gallery['grupal'][0]['alt'] }}">
                        <img src="{{ $gallery['grupal'][0]['src'] }}" alt="" loading="lazy" decoding="async" class="aspect-4/3 md:aspect-16/10 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                        <img src="{{ $gallery['grupal'][1]['src'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                    </button>
                    <div class="p-6">
                        <p class="font-semibold">{{ __('Presenciales') }}</p>
                        <p class="mt-2 text-neutral-600">{{ __('Sábados (Turno matutino o vespertino).') }}</p>
                    </div>
                </div>
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                    <button type="button" x-on:click="show('grupal', 2)" class="group relative block w-full cursor-zoom-in overflow-hidden focus-visible:outline-2 focus-visible:-outline-offset-4 focus-visible:outline-brand-blue" aria-label="{{ __('Ampliar foto') }}: {{ $gallery['grupal'][2]['alt'] }}">
                        <img src="{{ $gallery['grupal'][2]['src'] }}" alt="" loading="lazy" decoding="async" class="aspect-4/3 md:aspect-16/10 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                    </button>
                    <div class="p-6">
                        <p class="font-semibold">{{ __('En línea') }}</p>
                        <ul class="mt-2 space-y-1 text-neutral-600">
                            <li>{{ __('2 veces por semana (1.5 horas por sesión).') }}</li>
                            <li>{{ __('Lunes y Miércoles / Martes y Jueves') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <x-site.whatsapp-button class="mt-6"
                :message="__('Hola, me interesan las clases grupales bimestrales.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Clases particulares --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-2 lg:gap-16">
            <div class="lg:order-2">
            <x-site.section-heading :eyebrow="__('Modalidades')">{{ __('Clases particulares') }}</x-site.section-heading>
            <p class="mt-4 text-neutral-600">{{ __('Aprende a tu propio ritmo con un programa 100% personalizado.') }}
            </p>
            <div class="mt-6 grid gap-4">
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Grupos cerrados') }}</p>
                    <p class="mt-2 text-neutral-600">
                        {{ __('Clases individuales o en grupo privado con amigos o familia, sin integrar personas externas. 1-4 personas.') }}
                    </p>
                </div>
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Flexibilidad total') }}</p>
                    <p class="mt-2 text-neutral-600">
                        {{ __('Diseña tu propio calendario de estudio a partir de 1 hora por semana.') }}</p>
                </div>
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Modalidad libre') }}</p>
                    <p class="mt-2 text-neutral-600">
                        {{ __('Elige tomar tus clases en línea, en nuestras instalaciones o directamente a domicilio.') }}
                    </p>
                </div>
            </div>
            <x-site.whatsapp-button class="mt-6"
                :message="__(
                    'Hola, quiero solicitar una propuesta personalizada de clases particulares. Número de alumnos: , modalidad: , horario disponible: ',
                )">{{ __('¡Solicitar una propuesta personalizada!') }}</x-site.whatsapp-button>
            <p class="mt-3 text-sm text-neutral-500">
                {{ __('Envíanos un mensaje indicando el número de alumnos, modalidad de interés y tu horario disponible para enviarte una cotización a la medida.') }}
            </p>
            </div>

            {{-- One class in our classroom above, the online ones below: the "modalidad libre" made visible. --}}
            <div class="course-rail-reveal grid grid-cols-3 content-start gap-3 lg:sticky lg:top-28 lg:order-1 lg:self-start">
                @foreach ($gallery['particular'] as $photo)
                    <button
                        type="button"
                        x-on:click="show('particular', {{ $loop->index }})"
                        @class([
                            'group relative block cursor-zoom-in overflow-hidden rounded-2xl bg-neutral-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue',
                            'col-span-3' => $loop->first,
                        ])
                        aria-label="{{ __('Ampliar foto') }}: {{ $photo['alt'] }}"
                    >
                        <img src="{{ $photo['src'] }}" alt="" loading="lazy" decoding="async" @class([
                            'w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]',
                            'aspect-4/3' => $loop->first,
                            'aspect-square object-left-top' => ! $loop->first,
                        ])>
                        @if ($photo['online'])
                            <x-site.online-tag />
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Por qué IICC --}}
    {{--
        Editorial list beside a sticky Kai panel: the panel shows the character of the point
        nearest the middle of the screen (or the one hovered). On phones each point carries its own character.
    --}}
    <section
        class="bg-neutral-50 px-4 py-12 sm:py-20"
        x-data="{
            active: 0,
            observer: null,
            init() {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => entry.isIntersecting && (this.active = Number(entry.target.dataset.reason)));
                }, { rootMargin: '-45% 0px -45% 0px' });
                this.$el.querySelectorAll('[data-reason]').forEach((row) => this.observer.observe(row));
            },
            destroy() { this.observer?.disconnect(); },
        }"
    >
        <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] lg:gap-20">
            <div class="lg:sticky lg:top-28 lg:self-start">
                <x-site.section-heading
                    :eyebrow="__('IICC')">{{ __('¿Por qué aprender chino con el IICC?') }}</x-site.section-heading>

                <div class="course-reason-panel relative mt-10 hidden aspect-square overflow-hidden rounded-3xl bg-brand-blue lg:block" aria-hidden="true">
                    @foreach ($reasons as $reason)
                        <span
                            class="course-reason-glyph absolute inset-0 grid place-items-center font-kai text-[15rem] leading-none text-white select-none"
                            x-bind:class="active === {{ $loop->index }} && 'is-active'"
                            lang="zh-Hant"
                        >{{ $reason['glyph'] }}</span>
                    @endforeach
                    <div class="absolute inset-x-8 bottom-8 flex gap-1.5">
                        @foreach ($reasons as $reason)
                            <span class="h-1 flex-1 rounded-full bg-white/25 transition-colors duration-300" x-bind:class="active >= {{ $loop->index }} && 'bg-brand-orange!'"></span>
                        @endforeach
                    </div>
                </div>
            </div>

            <ol class="divide-y divide-neutral-200 border-y border-neutral-200">
                @foreach ($reasons as $reason)
                    <li
                        data-reason="{{ $loop->index }}"
                        x-on:mouseenter="active = {{ $loop->index }}"
                        class="grid grid-cols-[3.5rem_minmax(0,1fr)] gap-x-5 py-8 sm:grid-cols-[4.5rem_minmax(0,1fr)] lg:py-12"
                    >
                        <span
                            class="row-span-2 grid aspect-square place-items-center rounded-2xl bg-white font-kai text-4xl leading-none text-neutral-400 shadow-sm transition-colors duration-300 sm:text-5xl"
                            x-bind:class="active === {{ $loop->index }} && 'text-brand-orange!'"
                            lang="zh-Hant"
                            aria-hidden="true"
                        >{{ $reason['glyph'] }}</span>
                        <h3 class="text-xl font-semibold text-balance transition-colors duration-300 sm:text-2xl" x-bind:class="active === {{ $loop->index }} && 'text-brand-blue'">{{ $reason['title'] }}</h3>
                        <p class="mt-2 max-w-xl text-neutral-600">{{ $reason['body'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- CTA --}}
    <x-site.cta tone="dusk" :message="__('Hola, quiero información sobre los cursos de chino.')" :button="__('¡Contáctanos por WhatsApp!')">
        <x-slot:heading>{{ __('¿Listo para tu viaje al mundo chino?') }}</x-slot:heading>
    </x-site.cta>

    {{-- Photo lightbox: any class photo enlarged, browsable within its section --}}
    <template x-teleport="body">
        <div
            x-show="group !== null"
            x-cloak
            x-transition.opacity.duration.250ms
            class="fixed inset-0 z-60 flex flex-col items-center justify-center bg-neutral-950/90 p-4 backdrop-blur-sm sm:p-10"
            x-on:click.self="close()"
            x-on:keydown.arrow-right.window="group !== null && step(1)"
            x-on:keydown.arrow-left.window="group !== null && step(-1)"
            role="dialog"
            aria-modal="true"
            aria-label="{{ __('Foto ampliada') }}"
        >
            <template x-if="group !== null">
                <figure class="flex max-h-full w-full max-w-5xl flex-col items-center" x-trap.noscroll="group !== null">
                    <img
                        x-bind:key="gallery[group][index].src"
                        x-bind:src="gallery[group][index].src"
                        x-bind:alt="gallery[group][index].alt"
                        class="max-h-[78svh] w-auto rounded-2xl object-contain"
                    >
                    <figcaption class="mt-4 text-center text-white">
                        <span class="block text-base font-medium sm:text-lg" x-text="gallery[group][index].alt"></span>
                        <span class="mt-1 block text-sm text-white/60 tabular-nums" x-text="(index + 1) + ' / ' + gallery[group].length"></span>
                    </figcaption>
                </figure>
            </template>

            <button type="button" x-on:click="close()" class="absolute top-4 right-4 grid size-11 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95" aria-label="{{ __('Cerrar') }}">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
            <template x-if="group !== null && gallery[group].length > 1">
                <div>
                    <button type="button" x-on:click="step(-1)" class="absolute top-1/2 left-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95 sm:left-6" aria-label="{{ __('Anterior') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true" class="rotate-180"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" x-on:click="step(1)" class="absolute top-1/2 right-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95 sm:right-6" aria-label="{{ __('Siguiente') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </template>
        </div>
    </template>
</div>
</x-layouts.site>
