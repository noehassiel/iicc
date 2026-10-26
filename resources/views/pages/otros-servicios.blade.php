<x-layouts.site title="Otros Servicios">
    {{-- Hero --}}
    <section class="px-4 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl">
            <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Otros Servicios en IICC') }}</h1>
            <p class="mt-4 text-lg text-neutral-600">{{ __('Más allá del aula regular') }}</p>

            <div class="mt-10 grid gap-4 md:grid-cols-3">
                @foreach ([
                    [__('Formación Especial'), [__('Cursos de Verano'), __('Formación Docente')], '#formacion-especial'],
                    [__('Enlace Profesional'), [__('Traducción e Interpretación'), __('Guías de Turismo')], '#enlace-profesional'],
                    [__('Bolsa de Trabajo'), [__('Oportunidades Laborales'), __('Vinculación con Empresas')], '#bolsa-de-trabajo'],
                ] as [$title, $items, $anchor])
                    <article class="rounded-2xl bg-neutral-50 p-6">
                        <h2 class="text-xl font-semibold">{{ $title }}</h2>
                        <ul class="mt-3 space-y-1 text-neutral-600">
                            @foreach ($items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ $anchor }}" class="mt-4 inline-block font-semibold text-brand-blue">{{ __('Leer más') }} &rarr;</a>
                    </article>
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
                <dl class="space-y-5">
                    <div><dt class="font-semibold">{{ __('Aprendizaje Lúdico:') }}</dt><dd class="text-neutral-600">{{ __('Canciones, juegos tradicionales y dinámicas para aprender de forma natural.') }}</dd></div>
                    <div><dt class="font-semibold">{{ __('Pinyin y Escritura Básica:') }}</dt><dd class="text-neutral-600">{{ __('Fundamentos fonéticos, trazos iniciales y talleres culturales vivenciales.') }}</dd></div>
                    <div><dt class="font-semibold">{{ __('Continuidad Escolar:') }}</dt><dd class="text-neutral-600">{{ __('Pase directo para integrarse a nuestras clases regulares al finalizar el curso.') }}</dd></div>
                </dl>
                {{-- Video: cursos de verano 2026 --}}
                <div class="aspect-video rounded-2xl bg-neutral-200"></div>
            </div>

            <x-site.whatsapp-button :message="__('Hola, me gustaría conocer fechas y costos del curso de verano.')" class="mt-8">{{ __('Solicita fechas y costos a IICC') }}</x-site.whatsapp-button>

            <h3 class="mt-12 text-lg font-semibold">{{ __('Galería: Momentos de Nuestro Curso de Verano en 2026') }}</h3>
            <p class="mt-1 italic text-neutral-600">"{{ __('Descubre cómo nuestros estudiantes viven y disfrutan el idioma chino en IICC') }}"</p>
            {{-- Images: summer course 2026 gallery --}}
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach (range(1, 4) as $i)
                    <div class="aspect-square rounded-xl bg-neutral-200"></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Formación docente --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Formación Especial')">{{ __('Formación Docente y Oportunidades de Pasantía') }}</x-site.section-heading>
            <p class="mt-3 max-w-2xl text-neutral-600">{{ __('Capacitamos a los futuros profesionales de la enseñanza del chino mandarín con metodología práctica y experiencia real en el aula.') }}</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    [__('Materiales y Planificación'), [__('Recursos completos'), __('Diseño de clase')]],
                    [__('Observación de Clases'), [__('Observación guiada'), __('Gestión de aula')]],
                    [__('Prácticas y Suplencias'), [__('Práctica y suplencias'), __('Bolsa de talento')]],
                ] as [$title, $items])
                    <article class="rounded-2xl border p-6">
                        <h3 class="font-semibold">{{ $title }}</h3>
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
            <p class="mt-3 max-w-2xl text-neutral-600">{{ __('Conectamos tus requerimientos con especialistas bilingües (chino-español) calificados de nuestra red.') }}</p>

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
                ] as $caption)
                    <figure>
                        {{-- Image: interpreter at work (tap to enlarge) --}}
                        <div class="aspect-[4/3] rounded-xl bg-neutral-200"></div>
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
            <p class="mt-3 max-w-2xl text-neutral-600">{{ __('Conectamos el talento de nuestra comunidad con empresas que requieren el dominio del idioma chino.') }}</p>

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
</x-layouts.site>
