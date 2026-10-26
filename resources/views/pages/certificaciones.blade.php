@php
    $chinaExams = [
        ['name' => 'YCT', 'ages' => __('6 a 15 años.'), 'items' => [__('Examen escrito: 4 niveles (YCT 1, 2, 3 y 4).'), __('Examen oral (opcional): Nivel Inicial e Intermedio.')]],
        ['name' => 'HSK', 'detail' => __('(Escrito)'), 'ages' => __('A partir de 12 años.'), 'items' => [__('HSK 1–2: Comprensión auditiva y lectura.'), __('HSK 3–6: Comprensión auditiva, lectura y escritura.')]],
        ['name' => 'HSKK', 'detail' => __('(Oral)'), 'ages' => __('A partir de 12 años.'), 'items' => [__('Evaluación oral computarizada.'), __('Básico → HSK 1–2.'), __('Intermedio → HSK 3–4.'), __('Avanzado → HSK 5–6.')]],
        ['name' => 'BCT', 'ages' => __('A partir de 18 años.'), 'items' => [__('BCT (A) Negocios inicial.'), __('BCT (B) Negocios intermedio y avanzado.')]],
    ];

    $taiwanExams = [
        ['name' => 'CCCC', 'detail' => 'Children’s Chinese Competency Certification', 'description' => __('Certificación estandarizada para niños no nativos o de origen chino.'), 'ages' => __('7 a 12 años.'), 'items' => [__('Comprensión auditiva y lectura.'), __('Niveles: Sprouting, Seedling, Blossoming.')]],
        ['name' => 'TOCFL', 'detail' => 'Test of Chinese as a Foreign Language', 'description' => __('Examen oficial estandarizado desarrollado por el Ministerio de Educación de Taiwán.'), 'ages' => __('A partir de 12 años.'), 'items' => [__('Comprensión auditiva y lectura (principales).'), __('Expresión oral y escrita (opcionales).')]],
    ];

    $faqs = [
        [__('¿Por qué es importante certificarse?'), __('Aporta 3 ventajas clave: acceso a becas y admisiones universitarias, ventaja competitiva en el mercado laboral y medición objetiva de tu progreso real. Para asesoría personalizada, consulta con IICC.')],
        [__('¿Debo elegir TOCFL o HSK?'), __('Depende de tu objetivo: elige TOCFL para becas, estudios o empleo en Taiwán; elige HSK si buscas becas oficiales (CSC), estudiar o trabajar en China Continental y empresas multinacionales.')],
        [__('¿Puedo elegir entre caracteres tradicionales o simplificados?'), __('Sí. TOCFL ofrece ambas versiones; HSK se aplica solo en simplificados, pero admite respuestas en tradicionales. La evaluación es idéntica; elige según tu hábito.')],
        [__('¿Cómo elegir entre CCCC y YCT para niños?'), __('Según su material de estudio: CCCC si aprende con caracteres tradicionales o Zhuyin (sistema de Taiwán); YCT si estudia con caracteres simplificados y Pinyin (sistema de China Continental).')],
        [__('¿Tienen vigencia las certificaciones?'), __('TOCFL y CCCC tienen validez permanente. Para HSK / HSKK, la vigencia oficial para trámites académicos y becas es de 2 años.')],
        [__('Desde cero, ¿cuánto tiempo toma certificar HSK 1?'), __('De 8 a 10 meses con ritmo regular, dominando 300 palabras clave y las bases para conversaciones cotidianas elementales.')],
        [__('¿Cuánto tiempo toma alcanzar el nivel HSK 3?'), __('De 2 a 3 años. Permite consolidar más de 1,000 palabras y desenvolverse con autonomía en viajes, entornos laborales y expresión de opiniones.')],
    ];
@endphp

<x-layouts.site title="Certificaciones">
    {{-- Hero --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-semibold uppercase tracking-wider text-brand-blue">{{ __('Instituto de Idioma y Cultura China en México (IICC)') }}</p>
            <h1 class="mt-2 text-3xl font-semibold text-balance sm:text-5xl">{{ __('Guía de Certificaciones Oficiales de Chino Mandarín') }}</h1>
            <p class="mt-4 text-lg text-neutral-600">{{ __('Más de 20 años en México | Asesoría de profesores expertos') }}</p>
            <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero una consulta de orientación gratuita sobre certificaciones de chino.')">{{ __('Consulta de orientación gratuita') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Diferencias --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Comparativa')">{{ __('Diferencias entre sistemas de certificación') }}</x-site.section-heading>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('China') }}</h3>
                    <p class="text-sm text-neutral-500">(YCT, HSK, HSKK, BCT)</p>
                    <ul class="mt-4 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Becas oficiales') }}</li>
                        <li>{{ __('Estudio y trabajo') }}</li>
                        <li>{{ __('Certificación de negocios') }}</li>
                    </ul>
                    <a href="#china" class="mt-4 inline-block font-semibold text-brand-blue">{{ __('Ver detalles →') }}</a>
                </article>
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('Taiwán') }}</h3>
                    <p class="text-sm text-neutral-500">(CCCC, TOCFL)</p>
                    <ul class="mt-4 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Becas de Taiwán') }}</li>
                        <li>{{ __('Admisión universitaria') }}</li>
                        <li>{{ __('Puntos de empleo') }}</li>
                    </ul>
                    <a href="#taiwan" class="mt-4 inline-block font-semibold text-brand-blue">{{ __('Ver detalles →') }}</a>
                </article>
            </div>
        </div>
    </section>

    {{-- China --}}
    <section id="china" class="scroll-mt-24 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('China')">Chinese Proficiency Test</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-600">{{ __('Organizados por el Instituto Confucio, abarcan HSK, HSKK, YCT y BCT, son válidos para becas, estudios y empleo en empresas chinas.') }}</p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($chinaExams as $exam)
                    <article class="rounded-2xl border p-6">
                        <h3 class="text-xl font-semibold">{{ $exam['name'] }} <span class="text-sm font-normal text-neutral-500">{{ $exam['detail'] ?? '' }}</span></h3>
                        <p class="text-sm font-medium text-brand-blue">{{ $exam['ages'] }}</p>
                        <ul class="mt-3 space-y-1 text-neutral-600">
                            @foreach ($exam['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
            <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero informes del curso de preparación para HSK / YCT / BCT.')">{{ __('Informes del curso') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Taiwán --}}
    <section id="taiwan" class="scroll-mt-24 bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Taiwán')">Test of Chinese as a Foreign Language</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-600">{{ __('Examen oficial para hablantes no nativos avalado por el Ministerio de Educación de Taiwán (SC-TOP), con equivalencia internacional en CEFR y ACTFL.') }}</p>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                @foreach ($taiwanExams as $exam)
                    <article class="rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-semibold">{{ $exam['name'] }}</h3>
                        <p class="text-sm text-neutral-500">{{ $exam['detail'] }}</p>
                        <p class="mt-3 text-neutral-600">{{ $exam['description'] }}</p>
                        <p class="mt-3 text-sm font-medium text-brand-blue">{{ $exam['ages'] }}</p>
                        <ul class="mt-2 space-y-1 text-neutral-600">
                            @foreach ($exam['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
            <x-site.whatsapp-button class="mt-6" :message="__('Hola, quiero informes del curso de preparación para TOCFL / CCCC.')">{{ __('Informes del curso') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Programa de tutoría --}}
    <section class="px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('IICC')">{{ __('Programa de Tutoría y Certificación de IICC') }}</x-site.section-heading>
            <p class="mt-4 text-neutral-600">{{ __('Más de 20 años de experiencia en México × Equipo de profesores especializados') }}</p>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border p-6 text-neutral-600"><span class="font-semibold text-neutral-900">{{ __('Profesores certificados') }}</span> {{ __('con dominio total de TOCFL y HSK.') }}</div>
                <div class="rounded-2xl border p-6 text-neutral-600"><span class="font-semibold text-neutral-900">{{ __('Pruebas 100% oficiales') }}</span> {{ __('para superar puntos débiles y maximizar tu puntaje.') }}</div>
                <div class="rounded-2xl border p-6 text-neutral-600"><span class="font-semibold text-neutral-900">{{ __('Clases alineadas al examen oficial:') }}</span> {{ __('aprende y certifícate a la vez.') }}</div>
            </div>
            <p class="mt-8 text-neutral-600">{{ __('¿No estás seguro de qué nivel corresponde a tu hijo o a ti?') }}</p>
            <x-site.whatsapp-button class="mt-4" :message="__('Hola, quiero agendar un diagnóstico de nivel y asesoría gratuita.')">{{ __('Agendar diagnóstico de nivel y asesoría gratuita') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="bg-neutral-50 px-4 py-12 sm:py-20">
        <div class="mx-auto max-w-3xl">
            <x-site.section-heading :eyebrow="__('FAQ')">{{ __('Preguntas más frecuentes') }}</x-site.section-heading>
            <x-site.accordion class="mt-8" style="--accordion-surface: var(--color-white)" :items="$faqs" :title="__('Preguntas más frecuentes')" numbered />
            <p class="mt-8 text-center text-neutral-600">{{ __('¿No encontraste lo que buscabas? Contáctanos de inmediato') }}</p>
            <div class="mt-4 text-center">
                <x-site.whatsapp-button :message="__('Hola, tengo una pregunta sobre las certificaciones de chino.')">{{ __('Asesoría inmediata vía WhatsApp') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>
</x-layouts.site>
