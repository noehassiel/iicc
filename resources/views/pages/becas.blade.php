@php
    $taiwanScholarships = [
        [
            'id' => 'beca-taiwan-moe',
            'name' => __('Beca Taiwán (MOE)'),
            'call' => __('Convocatoria anual: Enero a marzo (Cierre habitual: 31 de marzo)'),
            'summary' => __('Programa de excelencia académica para cursar estudios superiores en Taiwán.'),
            'columns' => [
                __('Dirigido a') => __('Aspirantes con bachillerato o grado concluido interesados en cursar Licenciatura, Maestría o Doctorado en universidades taiwanesas.'),
                __('Beneficios') => __('Apoyo financiero para la colegiatura académica (total o parcial) más una asignación mensual fija para gastos de manutención.'),
                __('Requisitos clave') => __('Promedio alto, certificado (TOCFL o inglés) y 2 cartas de recomendación (en IICC te damos 1 carta y te acompañamos en tu proceso).'),
            ],
        ],
        [
            'id' => 'beca-huayu',
            'name' => __('Beca Huayu'),
            'call' => __('Convocatoria anual: Enero a marzo (Cierre habitual: 31 de marzo)'),
            'summary' => __('Estancias de inmersión y perfeccionamiento intensivo del idioma chino en Taiwán.'),
            'columns' => [
                __('Dirigido a') => __('Estudiantes mayores de 18 años con bachillerato concluido que deseen estudiar chino intensivo por periodos de 2 (verano), 3, 6, 9 o 12 meses.'),
                __('Beneficios') => __('Estipendio mensual de NT$28,000 para colegiatura, alojamiento y manutención. (Convocatoria 2026)'),
                __('Requisitos clave') => __('Promedio mín. 8.0, inglés B1 y 2 cartas de recomendación (en IICC te damos 1 carta y te acompañamos en tu proceso).'),
            ],
        ],
    ];

    $steps = [
        [__('Asesoría Inicial'), __('Evaluamos tu nivel actual de chino, definimos juntos tu objetivo (Taiwán o China Continental) y trazamos tu calendario de preparación ideal.')],
        [__('Cursos Intensivos y Certificación'), __('Refuerzas tu idioma con nuestros cursos intensivos para alcanzar el puntaje requerido en los exámenes oficiales (TOCFL / HSK).')],
        [__('Integración y Carta de Recomendación'), __('Revisamos tus documentos clave y la dirección académica del IICC emite 1 carta de recomendación para respaldar tu postulación.')],
        [__('Postulación Oficial'), __('Completas tu registro en línea y entregas tu expediente a tiempo ante la representación oficial correspondiente (enero a marzo).')],
    ];

    $faqs = [
        [__('¿Puedo postular a la Beca Huayu si apenas inicio en chino?'), __('Sí. La beca está diseñada para aprender chino en Taiwán y preparar allá tu TOCFL. Solo ten en cuenta que el certificado oficial de inglés (mín. B1) sí es obligatorio.')],
        [__('¿Cómo obtengo las cartas de recomendación?'), __('Como alumno regular de IICC con buen desempeño y asistencia, puedes solicitar a la Dirección Académica 1 carta para respaldar tu postulación.')],
        [__('¿Qué diferencia hay entre estudiar chino en Taiwán o en China Continental?'), __('La principal diferencia es el sistema de escritura: en Taiwán se emplean los caracteres tradicionales, mientras que en China Continental se utilizan los caracteres simplificados. En el IICC te enseñamos el sistema que mejor se adapte a tus objetivos.')],
        [__('¿Con cuánta anticipación debo prepararme para ir al extranjero?'), __('Las convocatorias se entregan entre enero y marzo. Te recomendamos iniciar tus cursos entre 6 y 12 meses antes para certificar tu nivel y armar tu expediente sin prisas.')],
        [__('¿Quién puede pedir la Beca de Excelencia IICC?'), __('Exclusiva para alumnos de cursos grupales (3 o más personas) con al menos 6 meses en IICC y promedio previo de 8.0. (No aplica para clases particulares).')],
        [__('¿Cómo se mantiene la Beca IICC durante el año?'), __('Se evalúa en diciembre y abril. Debes conservar un promedio mín. de 8.0 y 90% de asistencia en cada periodo; de lo contrario, el beneficio pasa al alumno en lista de espera.')],
        [__('¿En qué me apoya el IICC para conseguir una beca?'), __('Te brindamos cursos de preparación para exámenes oficiales (TOCFL / HSK), asesoría sobre el expediente y emitimos 1 carta de recomendación académica para respaldar tu postulación ante las instancias oficiales.')],
    ];
@endphp

<x-layouts.site title="Becas">
    {{-- Hero --}}
    <section class="px-4 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl">
            <h1 class="text-4xl font-semibold text-balance sm:text-5xl">{{ __('Impulsa tu futuro con nuestras') }} <span class="text-brand-blue">{{ __('BECAS') }}</span></h1>
            <p class="mt-4 max-w-xl text-lg text-neutral-600">{{ __('Premiamos tu esfuerzo académico y te abrimos las puertas a oportunidades de estudio en Taiwán y China Continental.') }}</p>
            <x-site.whatsapp-button :message="__('Hola, me gustaría recibir asesoría sobre becas.')" class="mt-8">{{ __('Solicita asesoría de becas') }}</x-site.whatsapp-button>
        </div>
    </section>

    {{-- Overview --}}
    <section class="bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading>{{ __('Becas para tu aprendizaje de chino') }}</x-site.section-heading>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('Beca de Excelencia IICC') }}</h3>
                    <p class="mt-2 text-neutral-600">{{ __('Premiamos tu esfuerzo y constancia con descuentos directos en tu colegiatura.') }}</p>
                    <p class="mt-4 font-medium">{{ __('Beneficios y requisitos:') }}</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Exclusivo para cursos grupales en todos los niveles.') }}</li>
                        <li>{{ __('Descuento directo en la colegiatura.') }}</li>
                        <li>{{ __('Evaluación periódica basada en promedio anual.') }}</li>
                    </ul>
                    <a href="#beca-excelencia" class="mt-6 inline-block font-semibold text-brand-blue">{{ __('Leer más') }} &rarr;</a>
                </article>

                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold">{{ __('Becas Internacionales') }}</h3>
                    <p class="mt-2 text-neutral-600">{{ __('Impulsamos tu postulación con cursos intensivos, información de becas y cartas de recomendación.') }}</p>
                    <p class="mt-4 font-medium">{{ __('Te apoyamos con:') }}</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Cursos intensivos de chino.') }}</li>
                        <li>{{ __('Información de convocatorias.') }}</li>
                        <li>{{ __('Cartas de recomendación académica.') }}</li>
                    </ul>
                    <a href="#becas-taiwan" class="mt-6 inline-block font-semibold text-brand-blue">{{ __('Leer más') }} &rarr;</a>
                </article>
            </div>
        </div>
    </section>

    {{-- Beca de Excelencia IICC --}}
    <section id="beca-excelencia" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Beca de Excelencia IICC')">{{ __('Reconocemos el compromiso, la disciplina y el talento de nuestros estudiantes en clases grupales.') }}</x-site.section-heading>

            {{-- Image: photo of the Excellence Scholarship recipients --}}
            <div class="mt-8 aspect-video rounded-2xl bg-neutral-100"></div>
            <blockquote class="mt-4 text-center italic text-neutral-600">"{{ __('Felicitamos a los beneficiarios de la Beca de Excelencia por su dedicación y constancia.') }}"</blockquote>

            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                <div class="rounded-2xl border p-6">
                    <h3 class="font-semibold">{{ __('Requisitos de Elegibilidad') }}</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Aplica únicamente para grupos integrados por 3 o más alumnos.') }}</li>
                        <li>{{ __('Haber estudiado un mínimo de 6 meses en el IICC.') }}</li>
                    </ul>
                </div>
                <div class="rounded-2xl border p-6">
                    <h3 class="font-semibold">{{ __('Criterios de Evaluación') }}</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Promedio mín. 8.0 en el ciclo anterior: Participación 30% · Exámenes 30% · Tareas 20% · Asistencia 20%') }}</li>
                        <li>{{ __('Se evaluará el desempeño de los becarios en diciembre y abril.') }}</li>
                    </ul>
                </div>
                <div class="rounded-2xl border p-6">
                    <h3 class="font-semibold">{{ __('Beneficios') }}</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('50% de descuento en la colegiatura bimestral del siguiente ciclo (no acumulable con otros descuentos).') }}</li>
                    </ul>
                </div>
                <div class="rounded-2xl border p-6">
                    <h3 class="font-semibold">{{ __('Calendario y Proceso') }}</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-neutral-600">
                        <li>{{ __('Periodo de postulación: A principios de agosto (convocatoria abierta durante 1 semana).') }}</li>
                    </ul>
                </div>
            </div>

            <p class="mt-6 rounded-2xl bg-brand-orange/15 p-4 text-sm"><strong>{{ __('CONDICIÓN DE PERMANENCIA:') }}</strong> {{ __('Si en el examen parcial se obtiene una calificación inferior a 8.0 o la asistencia no alcanza el 90%, la beca se cancelará y será transferida al alumno en lista de espera.') }}</p>

            <div class="mt-8 text-center">
                <p class="font-medium">{{ __('¿Tienes dudas sobre la beca escolar?') }}</p>
                <x-site.whatsapp-button :message="__('Hola, tengo dudas sobre la Beca de Excelencia IICC.')" class="mt-4">{{ __('¡Contáctanos!') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- Taiwán --}}
    <section id="becas-taiwan" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl space-y-12">
            @foreach ($taiwanScholarships as $scholarship)
                <article id="{{ $scholarship['id'] }}">
                    <h2 class="text-2xl font-semibold uppercase text-brand-blue">{{ $scholarship['name'] }}</h2>
                    <p class="mt-1 text-sm font-medium text-neutral-500">[{{ $scholarship['call'] }}]</p>
                    <p class="mt-3 text-neutral-700">{{ $scholarship['summary'] }}</p>

                    <dl class="mt-6 grid gap-4 md:grid-cols-3">
                        @foreach ($scholarship['columns'] as $label => $text)
                            <div class="rounded-2xl bg-white p-5 shadow-sm">
                                <dt class="font-semibold">{{ $label }}</dt>
                                <dd class="mt-2 text-neutral-600">{{ $text }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="https://taiwanscholarship.moe.gov.tw/web/pages.aspx?p=7" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-full border border-brand-blue px-6 py-3 font-semibold text-brand-blue">{{ __('Ver convocatoria oficial') }}</a>
                        <x-site.whatsapp-button :message="__('Hola, me interesa recibir asesoría sobre la :name.', ['name' => $scholarship['name']])">{{ __('¡Solicita asesoría a IICC!') }}</x-site.whatsapp-button>
                    </div>
                </article>
            @endforeach

            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold">{{ __('¿Buscas otras opciones de estudio en Taiwán?') }}</h3>
                <p class="mt-2 text-neutral-600">{{ __('Además de las convocatorias del Ministerio de Educación (MOE), existen otros programas de excelencia como la Beca ICDF (posgrados en áreas específicas) y becas directas de universidades taiwanesas. Consulta las convocatorias vigentes a través de la representación oficial.') }}</p>
                <a href="https://www.facebook.com/TaiwanenMexico/" target="_blank" rel="noopener" class="mt-4 inline-block font-semibold text-brand-blue">{{ __('Ver más en el Facebook de Taiwán en México') }} ↗</a>
            </div>
        </div>
    </section>

    {{-- Historias de éxito: Taiwán --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Historias de éxito')">{{ __('De México a Taiwán') }}</x-site.section-heading>
            <p class="mt-3 max-w-2xl text-neutral-600">{{ __('Descubre cómo es estudiar y vivir en Taiwán a través de los videos y vivencias compartidas por nuestros alumnos becados.') }}</p>

            {{-- Video: Nexmi, Camila --}}
            <div class="mt-8 aspect-video rounded-2xl bg-neutral-100"></div>
            <blockquote class="mt-4 italic text-neutral-700">"{{ __('Un vistazo real a las clases, el campus y la vida cotidiana viviendo en Taiwán.') }}"</blockquote>
            <p class="mt-2 text-sm text-neutral-500">{{ __('Alumno') }}: Nexmi, Camila ｜ {{ __('Beca') }}: {{ __('Beca Huayu (2025)') }} ｜ {{ __('Destino') }}: {{ __('Taipéi, Taiwán') }}</p>

            <dl class="mt-6 grid gap-4 sm:grid-cols-3">
                <div><dt class="font-semibold">{{ __('Clases reales:') }}</dt><dd class="text-neutral-600">{{ __('Inmersión en aulas universitarias.') }}</dd></div>
                <div><dt class="font-semibold">{{ __('Vida local:') }}</dt><dd class="text-neutral-600">{{ __('Convivencia y cultura en Taiwán.') }}</dd></div>
                <div><dt class="font-semibold">{{ __('Trayectoria:') }}</dt><dd class="text-neutral-600">{{ __('El camino del IICC a Taiwán.') }}</dd></div>
            </dl>

            <h3 class="mt-10 font-semibold">{{ __('Más momentos en Taiwán: Nuestros alumnos en el extranjero') }}</h3>
            {{-- Images: gallery of students in Taiwán --}}
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach (range(1, 4) as $i)
                    <div class="aspect-square rounded-xl bg-neutral-100"></div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <p class="font-medium">{{ __('¿Te gustaría vivir esta experiencia? Te asesoramos en tu postulación.') }}</p>
                <x-site.whatsapp-button :message="__('Hola, me gustaría estudiar en Taiwán. ¿Me pueden asesorar?')" class="mt-4">{{ __('¡Solicita asesoría a IICC!') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- China Continental --}}
    <section id="becas-china" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <h2 class="text-2xl font-semibold uppercase text-brand-blue">{{ __('Becas de China Continental') }}</h2>
            <p class="mt-3 text-neutral-700">{{ __('Oportunidades de estudio del idioma y programas de grado universitario en China Continental.') }}</p>

            <dl class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <dt class="font-semibold">{{ __('Dirigido a') }}</dt>
                    <dd class="mt-2 text-neutral-600">{{ __('Aspirantes interesados en realizar estancias de idioma chino, Licenciatura, Maestría o Doctorado en universidades de China.') }}</dd>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <dt class="font-semibold">{{ __('Beneficios') }}</dt>
                    <dd class="mt-2 text-neutral-600">{{ __('Exención de matrícula, alojamiento universitario y subsidio mensual para gastos personales (según el programa elegido).') }}</dd>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <dt class="font-semibold">{{ __('Requisitos de idioma') }}</dt>
                    <dd class="mt-2 text-neutral-600">{{ __('Según cada programa en Campus China: En chino: HSK nivel 3 o superior. En inglés: Certificado oficial de inglés con el nivel exigido.') }}</dd>
                </div>
            </dl>

            <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
                <h3 class="font-semibold">{{ __('¿Cómo podemos ayudarte en el IICC?') }}</h3>
                <p class="mt-2 text-neutral-600">{{ __('En IICC te brindamos la preparación lingüística y, a solicitud del alumno regular, emitimos 1 carta de recomendación académica. No obstante, la selección del programa y la postulación son 100% personales a través de Campus China.') }}</p>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <a href="https://www.campuschina.org/scholarships/index.html" target="_blank" rel="noopener" class="inline-flex items-center justify-center rounded-full border border-brand-blue px-6 py-3 font-semibold text-brand-blue">{{ __('Portal Oficial: Campus China') }} (<span lang="zh-Hant">留學中國</span>)</a>
                <x-site.whatsapp-button :message="__('Hola, me interesa recibir asesoría sobre becas en China Continental.')">{{ __('¡Solicita asesoría a IICC!') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- Historias de éxito: China --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Historias de éxito')">{{ __('De México a China Continental') }}</x-site.section-heading>
            <p class="mt-3 max-w-2xl text-neutral-600">{{ __('Descubre cómo es estudiar y vivir en China a través de los videos y vivencias compartidas por nuestros alumnos becados.') }}</p>

            {{-- Video: Gonzalo --}}
            <div class="mt-8 aspect-video rounded-2xl bg-neutral-100"></div>
            <blockquote class="mt-4 italic text-neutral-700">“{{ __('De la beca al mundo laboral en Pekín.') }}”</blockquote>
            <p class="mt-2 text-sm text-neutral-500">{{ __('Alumno') }}: Gonzalo ｜ {{ __('Beca') }}: {{ __('Beca CI (2023-2024)') }} ｜ {{ __('Destino') }}: {{ __('Pekín, China') }}</p>

            <dl class="mt-6 grid gap-4 sm:grid-cols-3">
                <div><dt class="font-semibold">{{ __('Estudio y dominio:') }}</dt><dd class="text-neutral-600">{{ __('Inmersión lingüística universitaria.') }}</dd></div>
                <div><dt class="font-semibold">{{ __('Inserción laboral:') }}</dt><dd class="text-neutral-600">{{ __('Empleo profesional en Pekín.') }}</dd></div>
                <div><dt class="font-semibold">{{ __('Salto profesional:') }}</dt><dd class="text-neutral-600">{{ __('Del IICC al mercado internacional.') }}</dd></div>
            </dl>

            <h3 class="mt-10 font-semibold">{{ __('Más momentos en China Continental: Nuestros alumnos en el extranjero') }}</h3>
            {{-- Images: gallery of students in China --}}
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach (range(1, 4) as $i)
                    <div class="aspect-square rounded-xl bg-neutral-100"></div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <p class="font-medium">{{ __('¿Estudiar y trabajar en China? Te ayudamos a postularte.') }}</p>
                <x-site.whatsapp-button :message="__('Hola, me gustaría estudiar en China Continental. ¿Me pueden asesorar?')" class="mt-4">{{ __('¡Solicita asesoría a IICC!') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- Ruta --}}
    <section class="bg-brand-blue px-4 py-16 text-white">
        <div class="mx-auto max-w-7xl">
            <h2 class="text-2xl font-semibold sm:text-3xl">{{ __('Tu Ruta hacia la Beca con el Respaldo de IICC') }}</h2>
            <p class="mt-3 text-white/80">{{ __('Te acompañamos desde tu primera clase hasta la entrega formal de tu expediente.') }}</p>

            <ol class="mt-8 grid gap-4 md:grid-cols-4">
                @foreach ($steps as [$title, $text])
                    <li class="rounded-2xl bg-white/10 p-5">
                        <span class="text-3xl font-semibold text-brand-orange">{{ $loop->iteration }}</span>
                        <h3 class="mt-2 font-semibold">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-white/80">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>

            <div class="mt-8 text-center">
                <p class="text-white/80">{{ __('¿Planeas postular este año o el próximo? Da el primer paso hoy mismo.') }}</p>
                <x-site.whatsapp-button :message="__('Hola, quiero iniciar mi asesoría de becas con IICC.')" class="mt-4">{{ __('Inicia tu asesoría con IICC') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="px-4 py-16">
        <div class="mx-auto max-w-3xl">
            <x-site.section-heading>{{ __('Preguntas Más Frecuentes (FAQ)') }}</x-site.section-heading>

            <x-site.accordion class="mt-8" :items="$faqs" :title="__('Preguntas Más Frecuentes (FAQ)')" numbered />

            <div class="mt-8 text-center">
                <p class="text-neutral-600">{{ __('¿No encontraste lo que buscabas? Contáctanos de inmediato.') }}</p>
                <x-site.whatsapp-button :message="__('Hola, tengo una pregunta sobre becas.')" class="mt-4">{{ __('Asesoría inmediata a IICC') }}</x-site.whatsapp-button>
            </div>
        </div>
    </section>
</x-layouts.site>
