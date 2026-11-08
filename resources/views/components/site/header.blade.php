@php
    $chevron = '<svg class="nav-chevron" viewBox="0 0 12 12" aria-hidden="true"><path d="M2.5 4.5 6 8l3.5-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>';

    $courses = [
        ['href' => route('cursos').'#ninos', 'title' => __('Niños'), 'description' => __('6 – 11 años'), 'glyph' => '兒童', 'color' => 'var(--color-brand-orange)'],
        ['href' => route('cursos').'#adolescentes', 'title' => __('Adolescentes'), 'description' => __('12 – 17 años'), 'glyph' => '青少年', 'color' => 'var(--color-brand-green)'],
        ['href' => route('cursos').'#adultos', 'title' => __('Adultos'), 'description' => __('> 18 años'), 'glyph' => '成人', 'color' => 'var(--color-brand-blue)'],
    ];

    $certifications = [
        ['href' => route('certificaciones').'#china', 'title' => __('China'), 'description' => __('Chinese Proficiency Test'), 'glyph' => '中國', 'color' => '#b3261e'],
        ['href' => route('certificaciones').'#taiwan', 'title' => __('Taiwán'), 'description' => __('Test of Chinese as a Foreign Language'), 'glyph' => '臺灣', 'color' => 'var(--color-brand-blue)'],
    ];

    $scholarships = [
        ['href' => route('becas').'#beca-excelencia', 'title' => __('Beca de Excelencia IICC')],
        ['href' => route('becas').'#becas-taiwan', 'title' => __('Becas de Taiwán')],
        ['href' => route('becas').'#becas-china', 'title' => __('Becas de China Continental')],
    ];

    $services = [
        ['href' => route('otros-servicios').'#formacion-especial', 'title' => __('Formación Especial')],
        ['href' => route('otros-servicios').'#enlace-profesional', 'title' => __('Enlace Profesional')],
        ['href' => route('otros-servicios').'#bolsa-de-trabajo', 'title' => __('Bolsa de Trabajo')],
    ];

    $flyouts = [
        'cursos' => __('Cursos'),
        'certificaciones' => __('Certificaciones'),
        'becas' => __('Becas'),
        'otros-servicios' => __('Otros Servicios'),
    ];
@endphp

<header class="navigation-01-header">
    <div class="header-shell">
        <div class="header-bar" aria-hidden="true"></div>
        <div class="header-content">
            <a class="logo flex! items-center gap-2 font-semibold tracking-wide" href="{{ route('home') }}" aria-label="{{ __('IICC — Inicio') }}">
                <span>IICC</span>
                <span lang="zh-Hant" class="hidden text-xs font-normal text-white/60 sm:inline">中華文化學院</span>
            </a>

            <nav class="navigation-01" aria-label="{{ __('Menú principal') }}">
                <ul class="nav-list">
                    <li>
                        <a class="nav-item" href="{{ route('home') }}">{{ __('Inicio') }}</a>
                    </li>

                    @foreach ($flyouts as $key => $label)
                        <li>
                            <button type="button" class="nav-item" data-flyout="{{ $key }}" aria-expanded="false" aria-haspopup="true">
                                {{ $label }}
                                {!! $chevron !!}
                            </button>
                            <div class="nav-accordion" data-accordion="{{ $key }}">
                                <div class="nav-accordion__inner"></div>
                            </div>
                        </li>
                    @endforeach

                    <li>
                        <a class="nav-item" href="{{ route('eventos.index') }}">{{ __('Eventos') }}</a>
                    </li>
                    <li>
                        <a class="nav-item" href="{{ route('nosotros') }}">{{ __('Nosotros') }}</a>
                    </li>
                </ul>

                <span class="nav-hover-bg" aria-hidden="true"></span>

                <div class="nav-flyout" hidden>
                    <div class="nav-flyout__bg" aria-hidden="true"></div>
                    <div class="nav-flyout__viewport">
                        <div class="nav-flyout__panel nav-flyout__panel--mega" data-panel="cursos">
                            <div class="nav-dropdown__inner">
                                <div class="nav-dropdown__sidebar">
                                    <span class="nav-dropdown__pill" aria-hidden="true"></span>
                                    <ul class="nav-dropdown__list">
                                        @foreach ($courses as $course)
                                            <li>
                                                <a class="nav-dropdown__item" href="{{ $course['href'] }}" data-preview-index="{{ $loop->index }}">
                                                    <span class="nav-dropdown__title">{{ $course['title'] }}</span>
                                                    <span class="nav-dropdown__description">{{ $course['description'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <a class="nav-dropdown__item" href="{{ route('cursos') }}" data-preview-index="{{ count($courses) }}">
                                                <span class="nav-dropdown__title">{{ __('Todos los cursos') }}</span>
                                                <span class="nav-dropdown__description">{{ __('Presencial o en línea') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="nav-dropdown__preview" aria-hidden="true">
                                    @foreach ([...$courses, ['glyph' => '中文', 'color' => '#0f213d']] as $course)
                                        <div @class(['nav-dropdown__preview-panel', 'is-active' => $loop->first]) data-preview-index="{{ $loop->index }}">
                                            <div class="nav-dropdown__placeholder" style="background-color: {{ $course['color'] }}">
                                                <span lang="zh-Hant" class="nav-dropdown__glyph">{{ $course['glyph'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="nav-flyout__panel nav-flyout__panel--featured" data-panel="certificaciones">
                            <div class="nav-dropdown__inner">
                                @foreach ($certifications as $certification)
                                    <a class="nav-featured__card" href="{{ $certification['href'] }}">
                                        <span lang="zh-Hant" class="nav-featured__image nav-featured__image--glyph" style="background-color: {{ $certification['color'] }}" aria-hidden="true">{{ $certification['glyph'] }}</span>
                                        <span class="nav-featured__content">
                                            <span class="nav-dropdown__title">{{ $certification['title'] }}</span>
                                            <span class="nav-dropdown__description">{{ $certification['description'] }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        @foreach (['becas' => $scholarships, 'otros-servicios' => $services] as $key => $items)
                            <div class="nav-flyout__panel nav-flyout__panel--simple" data-panel="{{ $key }}">
                                <div class="nav-dropdown__inner">
                                    <span class="nav-dropdown__pill" aria-hidden="true"></span>
                                    <ul class="nav-dropdown__list">
                                        @foreach ($items as $item)
                                            <li><a class="nav-dropdown__item" href="{{ $item['href'] }}"><span class="nav-dropdown__title">{{ $item['title'] }}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="header-actions">
                <x-site.locale-toggle />

                <a class="cta" href="{{ route('contacto') }}"><span>{{ __('Contacto') }}</span></a>
            </div>

            <button type="button" class="nav-menu-toggle" aria-expanded="false" aria-label="{{ __('Abrir menú') }}">
                <span class="nav-menu-toggle__icon" aria-hidden="true">
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </div>
</header>
