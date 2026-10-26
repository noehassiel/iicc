@php
    $ageGroups = [
        ['id' => 'ninos', 'title' => __('Niños'), 'ages' => __('6 – 11 años'), 'focus' => __('Aprende chino de forma lúdico a través de juegos, canciones y manualidades para sentar bases sólidas.')],
        ['id' => 'adolescentes', 'title' => __('Adolescentes'), 'ages' => __('12 – 17 años'), 'focus' => __('Aprende chino de forma natural y comunícate con las bases del idioma chino.')],
        ['id' => 'adultos', 'title' => __('Adultos'), 'ages' => __('> 18 años'), 'focus' => __('Conversación en contextos reales, gramática esencial y preparación para exámenes oficiales.')],
    ];

    $reasons = [
        ['title' => __('Grupos reducidos'), 'body' => __('Máximo 10 personas por clase para garantizar tu participación activa y resolver tus dudas al instante.')],
        ['title' => __('Profesores nativos calificados'), 'body' => __('Aprende de auténticos hablantes nativos. Nuestro equipo docente te guiará con la mejor metodología, corrigiendo tu pronunciación y entonación desde las bases.')],
        ['title' => __('Actividades culturales mensuales'), 'body' => __('Más que un idioma, una experiencia viva. Cada mes realizamos actividades de caligrafía, gastronomía, té y festividades tradicionales chinas. (Son incluidas en los cursos.)')],
        ['title' => __('Becas escolares y a Taiwán o China'), 'body' => __('Impulsamos tu camino académico. Premiamos tu constancia con becas internas de excelencia y te apoyamos para postular a becas gubernamentales e internacionales.')],
        ['title' => __('Caracteres simplificados y tradicionales'), 'body' => __('Enseñamos ambos sistemas de escritura para que elijas el que mejor se adapte a tus intereses académicos o laborales.')],
    ];
@endphp

<x-layouts.site title="Cursos">
    {{-- Hero --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-2 lg:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-balance sm:text-5xl">{{ __('Aprender chino en IICC') }}</h1>
                <p class="mt-4 text-lg text-neutral-600">{{ __('Tenemos más de 20 años de experiencia en la enseñanza de chino mandarín, y ofrecemos varios servicios de cursos para usted.') }}</p>
            </div>
            {{-- Image: foto para la página de cursos --}}
            <div class="aspect-[4/3] rounded-2xl bg-neutral-100"></div>
        </div>
    </section>

    {{-- Cursos por edades --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Cursos')">{{ __('Cursos por edades') }}</x-site.section-heading>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach ($ageGroups as $group)
                    <article class="flex flex-col rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold">{{ $group['title'] }}</h3>
                        <p class="text-sm font-medium text-brand-blue">{{ $group['ages'] }}</p>
                        <p class="mt-3 flex-1 text-neutral-600"><span class="font-medium text-neutral-900">{{ __('Enfoque:') }}</span> {{ $group['focus'] }}</p>
                        <a href="#{{ $group['id'] }}" class="mt-4 font-semibold text-brand-blue">{{ __('Lee más →') }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Mapa de niveles --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl space-y-12">
            <x-site.section-heading :eyebrow="__('Niveles')">{{ __('Mapa de niveles') }}</x-site.section-heading>

            <div id="ninos" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Niños (6 – 11 años)') }}</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Tradicional') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Dirigido a los niños taiwaneses o interesados en caracteres tradicionales.') }}</li>
                            <li>Bopomofo (<span lang="zh-Hant">ㄅㄆㄇ數來寶</span>), Living Mandarin, {{ __('Material personalizado') }}</li>
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
                    <p class="mt-1 text-neutral-600">{{ __('Diseñada para la continuidad del currículo oficial de China continental a partir de los 10 años. (Más informes en recepción).') }}</p>
                </div>
                <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero inscribir a mi hijo(a) en el curso de chino para niños.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
            </div>

            <div id="adolescentes" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Adolescentes (12 – 17 años)') }}</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border p-6">
                        <p class="font-semibold">{{ __('Material: Chino Tradicional') }}</p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                            <li>{{ __('Dirigido a los adolescentes taiwaneses o interesados en caracteres tradicionales.') }}</li>
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
                <x-site.whatsapp-button class="mt-6" :message="__('Hola, me interesa el curso de chino para adolescentes.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
            </div>

            <div id="adultos" class="scroll-mt-24">
                <h3 class="text-xl font-semibold">{{ __('Adultos (> 18 años)') }}</h3>
                <div class="mt-4 rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Material: Chino Simplificado') }}</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Para los que inician su aprendizaje del chino estándar.') }}</li>
                        <li>{{ __('Chino Hoy, HSK y Material personalizado') }}</li>
                    </ul>
                </div>
                <div class="mt-4 rounded-2xl bg-brand-blue/5 p-6">
                    <p class="font-semibold">{{ __('Pasos de aprendizaje') }}</p>
                    <p class="mt-1 text-neutral-600">{{ __('Al concluir la serie Chino Hoy, se alcanza el nivel HSK 2, con transición directa a los cursos avanzados a partir de HSK 3.') }}</p>
                </div>
                <x-site.whatsapp-button class="mt-6" :message="__('Hola, me interesa el curso de chino para adultos.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
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
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="font-semibold">{{ __('Presenciales') }}</p>
                    <p class="mt-2 text-neutral-600">{{ __('Sábados (Turno matutino o vespertino).') }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="font-semibold">{{ __('En línea') }}</p>
                    <ul class="mt-2 space-y-1 text-neutral-600">
                        <li>{{ __('2 veces por semana (1.5 horas por sesión).') }}</li>
                        <li>{{ __('Lunes y Miércoles / Martes y Jueves') }}</li>
                    </ul>
                </div>
            </div>
            <x-site.whatsapp-button class="mt-6" :message="__('Hola, me interesan las clases grupales bimestrales.')">{{ __('¡Inscríbete ahora!') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Clases particulares --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Modalidades')">{{ __('Clases particulares') }}</x-site.section-heading>
            <p class="mt-4 text-neutral-600">{{ __('Aprende a tu propio ritmo con un programa 100% personalizado.') }}</p>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Grupos cerrados') }}</p>
                    <p class="mt-2 text-neutral-600">{{ __('Clases individuales o en grupo privado con amigos o familia, sin integrar personas externas. 1-4 personas.') }}</p>
                </div>
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Flexibilidad total') }}</p>
                    <p class="mt-2 text-neutral-600">{{ __('Diseña tu propio calendario de estudio a partir de 1 hora por semana.') }}</p>
                </div>
                <div class="rounded-2xl border p-6">
                    <p class="font-semibold">{{ __('Modalidad libre') }}</p>
                    <p class="mt-2 text-neutral-600">{{ __('Elige tomar tus clases en línea, en nuestras instalaciones o directamente a domicilio.') }}</p>
                </div>
            </div>
            <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero solicitar una propuesta personalizada de clases particulares. Número de alumnos: , modalidad: , horario disponible: ')">{{ __('¡Solicitar una propuesta personalizada!') }}</x-site.whatsapp-button>
            <p class="mt-3 text-sm text-neutral-500">{{ __('Envíanos un mensaje indicando el número de alumnos, modalidad de interés y tu horario disponible para enviarte una cotización a la medida.') }}</p>
        </div>
    </section>

    {{-- Por qué IICC --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('IICC')">{{ __('¿Por qué aprender chino con el IICC?') }}</x-site.section-heading>
            <ol class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($reasons as $reason)
                    <li class="rounded-2xl bg-white p-6 shadow-sm">
                        <span class="text-sm font-semibold text-brand-orange">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="mt-1 font-semibold">{{ $reason['title'] }}</p>
                        <p class="mt-2 text-neutral-600">{{ $reason['body'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-4 py-16 text-center">
        <h2 class="text-2xl font-semibold sm:text-3xl">{{ __('¿Listo para tu viaje al mundo chino?') }}</h2>
        <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero información sobre los cursos de chino.')">{{ __('¡Contáctanos por WhatsApp!') }}</x-site.whatsapp-button>
    </section>
</x-layouts.site>
