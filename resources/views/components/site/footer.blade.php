@php
    $socials = [
        ['href' => 'https://wa.me/'.config('site.whatsapp'), 'label' => 'WhatsApp'],
        ['href' => 'https://www.facebook.com/', 'label' => 'Facebook'],
        ['href' => 'https://www.instagram.com/iiccmex', 'label' => 'Instagram'],
        ['href' => 'https://www.youtube.com/', 'label' => 'YouTube'],
    ];
@endphp

<footer class="relative bg-[#e4e0d8] text-[#14110f] lg:min-h-svh">
    {{-- Cropped visual band, standing in for the reference's portrait --}}
    <div class="relative h-[62vw] overflow-hidden bg-[#d6d2c9] sm:h-[44vw] lg:h-[36vw] lg:max-h-[30rem]" aria-hidden="true">
        <span lang="zh-Hant" class="absolute -right-[4vw] -bottom-[12vw] text-[46vw] leading-none font-semibold tracking-[-0.08em] text-[#ccc7bd] select-none lg:-bottom-[9vw] lg:text-[34vw]">中文</span>
    </div>

    <a href="{{ route('home') }}" class="absolute top-3 left-4 text-[22vw] leading-[0.8] font-semibold tracking-[-0.065em] sm:left-6 sm:text-[16vw] lg:text-[10.5rem]" aria-label="{{ __('IICC — Inicio') }}">IICC</a>

    <div class="grid lg:grid-cols-[1fr_38%]">
        <div class="flex flex-col px-4 pt-6 pb-16 sm:px-6 lg:pt-5">
            <p class="text-lg tracking-tight">{{ __('Contacto') }}</p>

            <div class="mt-16 text-[2rem] leading-[1.05] tracking-[-0.03em] sm:text-5xl lg:mt-auto lg:pt-40">
                <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" class="block w-fit">{{ config('site.whatsapp_display') }}</a>
                <p class="mt-1 max-w-[26ch] text-[#14110f]/55 text-xl leading-snug tracking-tight sm:text-2xl">Tomas Alva Edison 92A, Tabacalera, Cuauhtémoc, CDMX</p>
                <a
                    href="https://wa.me/{{ config('site.whatsapp') }}?text={{ rawurlencode(__('Hola, quisiera información sobre los cursos de IICC.')) }}"
                    target="_blank"
                    rel="noopener"
                    class="group mt-3 inline-flex w-fit items-center gap-3 border-b-2 border-current text-[#5b86b3]"
                >
                    {{ __('¡Contáctanos por WhatsApp!') }}
                    <span aria-hidden="true" class="transition-transform duration-300 ease-out group-hover:translate-x-2">&rarr;</span>
                </a>
            </div>

            <ul class="mt-14 grid w-fit grid-cols-2 gap-x-24 gap-y-2 text-lg tracking-tight sm:flex sm:gap-x-24">
                @foreach ($socials as $social)
                    <li><a href="{{ $social['href'] }}" target="_blank" rel="noopener" class="transition-opacity hover:opacity-60">{{ $social['label'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- Dark panel that rides up over the visual band --}}
        <figure class="relative z-10 mx-4 flex flex-col bg-[#1c1815] p-4 text-white sm:mx-6 lg:mx-0 lg:-mt-[calc(min(36vw,30rem)*0.45)] lg:mb-16">
            <blockquote class="flex gap-6 text-lg leading-snug tracking-tight sm:text-xl">
                <span aria-hidden="true">“</span>
                <p class="flex-1">Una de las pocas escuelas de mandarín en la Ciudad de México. Es una escuela relativamente pequeña con un programa completo de mandarín y un programa de inmersión en la cultura china.</p>
                <span aria-hidden="true">”</span>
            </blockquote>
            <figcaption class="mt-3 pl-8 text-sm text-white/50">Andi Gonzalez · {{ __('Reseña de Google') }}</figcaption>

            <div class="mt-10 flex aspect-[4/3] items-end justify-between overflow-hidden bg-brand-blue p-4 lg:mt-auto" aria-hidden="true">
                <span lang="zh-Hant" class="text-[5.5rem] leading-[0.85] font-semibold tracking-[-0.06em] text-white/90 sm:text-9xl">中華<br>文化</span>
                <span class="mb-2 size-14 rounded-full bg-brand-orange sm:size-20"></span>
            </div>
        </figure>
    </div>

    <div class="grid gap-4 px-4 pt-10 pb-5 text-[0.7rem] leading-tight uppercase sm:px-6 lg:absolute lg:inset-x-0 lg:bottom-0 lg:pt-0 lg:grid-cols-[1fr_19%_19%]">
        <p>IICC<br>{{ __('Instituto de Idioma y Cultura China en México, A.C.') }}</p>
        <p><a href="{{ route('contacto') }}" class="hover:opacity-60">{{ __('Contacto') }}</a><br>IICC&copy;{{ date('Y') }}</p>
        <p class="lg:text-right" lang="zh-Hant">墨西哥中華文化學院<br>{{ __('Ciudad de México') }}</p>
    </div>
</footer>
