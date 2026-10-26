@php
    $staff = [
        ['name' => 'Grace Zhang', 'role' => __('Directora General del IICC'), 'image' => __('Foto de directora')],
        ['name' => 'Jeymmi', 'role' => __('Coordinación y Admisiones'), 'image' => __('Foto de secretaria')],
        ['name' => 'Juan', 'role' => __('Seguridad y Atención en Campus'), 'image' => __('Foto de guardia de seguridad')],
    ];

    $achievements = [
        ['value' => 12000, 'label' => __('Alumnos formados en el IICC desde 2003')],
        ['value' => 500, 'label' => __('Alumnos certificados en TOCFL y HSK')],
        ['value' => 150, 'label' => __('Niños y jóvenes certificados en YCT y CCCC')],
    ];

    $spaces = [
        ['title' => __('Planta Baja (afuera)'), 'text' => __('Un amplio patio al aire libre donde se celebran talleres culturales mensuales y eventos comunitarios; el lugar de juego favorito durante el recreo. Cuenta además con cocina para talleres y sanitarios para hombres al fondo.')],
        ['title' => __('Planta Baja (interior)'), 'text' => __('La planta baja alberga dos cómodas aulas de clase, el área de recepción y secretaría para atención a alumnos, y la oficina de dirección general.')],
        ['title' => __('Primer Piso'), 'text' => __('Espacio de aulas múltiples: cuenta con un gran salón interactivo para cursos infantiles y campamentos, tres aulas adicionales y sanitarios para damas.')],
    ];
@endphp

<x-layouts.site title="Nosotros">
    <section class="bg-brand-blue px-4 py-16 text-white">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-semibold uppercase tracking-wider text-white/70">{{ __('Nosotros') }}</p>
            <h1 class="mt-2 max-w-2xl text-3xl font-semibold text-balance sm:text-5xl">{{ __('Aprendiendo chino y tendiendo puentes culturales desde 2003') }}</h1>

            <nav class="mt-8 flex flex-wrap gap-3">
                <a href="#historia" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestra Historia') }}</a>
                <a href="#equipo" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestro Equipo') }}</a>
                <a href="#instituto" class="rounded-full bg-white px-5 py-2 font-semibold text-brand-blue">{{ __('Nuestro Instituto') }}</a>
            </nav>
        </div>
    </section>

    <section id="historia" class="scroll-mt-20 px-4 py-16">
        <div class="mx-auto grid max-w-7xl gap-8 md:grid-cols-2 md:items-center">
            <div>
                <x-site.section-heading :eyebrow="__('Nuestra Historia')">{{ __('Desde 2003: Mucho más que una escuela') }}</x-site.section-heading>
                <p class="mt-4 text-neutral-700">{{ __('Desde 2003, en el IICC unimos idioma y cultura como un legado vivo. Somos un puente humano para que México descubra la tradición china y un espacio de auténtica reconexión cultural para que la comunidad china en el extranjero se reencuentre con sus raíces.') }}</p>
            </div>
            {{-- Imagen: fotos juntos o video de presentación --}}
            <div class="aspect-video rounded-2xl bg-neutral-100"></div>
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
        {{-- Pendiente: valores del IICC (solo ícono y tema) --}}
    </section>

    <section id="equipo" class="scroll-mt-20 bg-neutral-50 px-4 py-16">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading :eyebrow="__('Nuestro Equipo')">{{ __('Equipo de Coordinación') }}</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-700">{{ __('Las personas que te acompañan día con día: un equipo dedicado a guiarte, resolver tus dudas y cuidar de tu estancia en el IICC dentro y fuera del aula.') }}</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                @foreach ($staff as $person)
                    <div>
                        {{-- Imagen: {{ $person['image'] }} --}}
                        <div class="aspect-square rounded-2xl bg-neutral-200"></div>
                        <p class="mt-3 font-semibold">{{ $person['name'] }}</p>
                        <p class="text-sm text-neutral-600">{{ $person['role'] }}</p>
                    </div>
                @endforeach
            </div>

            <x-site.section-heading class="mt-16">{{ __('Conoce a Nuestros Maestros Expertos') }}</x-site.section-heading>
            <p class="mt-4 max-w-2xl text-neutral-700">{{ __('Profesores nativos y certificados que combinan experiencia pedagógica con una auténtica pasión por enseñar. Te acompañamos paso a paso con paciencia, dinamismo y grupos reducidos para que hables chino con naturalidad.') }}</p>

            {{-- 12 maestros en carrusel con flechas; datos pendientes del cliente --}}
            <div class="-mx-4 mt-8 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-4">
                @foreach (range(1, 12) as $teacher)
                    <div class="w-2/3 shrink-0 snap-start sm:w-1/4">
                        {{-- Imagen: foto de maestro --}}
                        <div class="aspect-square rounded-2xl bg-neutral-200"></div>
                        <p class="mt-3 font-semibold">{{ __('Nombre') }}</p>
                        <p class="text-sm text-neutral-600">{{ __('Años de enseñanza') }}</p>
                        <p class="text-sm text-neutral-600">{{ __('Clase presencial o en línea') }}</p>
                    </div>
                @endforeach
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
                    <x-site.section-heading :eyebrow="__('Nuestro Instituto')">{{ __('Un entorno luminoso y acogedor, pensado para aprender con calma y vivir la cultura.') }}</x-site.section-heading>
                    <p class="mt-4 text-neutral-700">{{ __('Ubicado en el corazón de la Ciudad de México, a pocos pasos del emblemático Monumento a la Revolución, el IICC cuenta con instalaciones cómodas, seguras y luminosas diseñadas para el bienestar de nuestra comunidad. Nuestro campus combina la tranquilidad necesaria para el estudio con espacios abiertos para la convivencia y el intercambio cultural.') }}</p>
                </div>
                {{-- Video: video del instituto --}}
                <div class="aspect-video rounded-2xl bg-neutral-200"></div>
            </div>

            {{-- "Ver galería" abrirá un lightbox deslizable con título, descripción y contador (ej. 2 / 4) --}}
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($spaces as $space)
                    <article class="overflow-hidden rounded-2xl bg-white">
                        {{-- Imagen: fotos de {{ $space['title'] }} del IICC --}}
                        <div class="aspect-4/3 bg-neutral-200"></div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">{{ $space['title'] }}</h3>
                            <p class="mt-2 text-neutral-600">{{ $space['text'] }}</p>
                            <button type="button" class="mt-4 font-semibold text-brand-blue">{{ __('Ver galería →') }}</button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.site>
