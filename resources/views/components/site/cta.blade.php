@props(['message' => null, 'button', 'tone' => 'blue'])

@php
    $isLight = $tone === 'orange';
@endphp

{{-- Closing call to action: a full-width rounded card whose gradient drifts slowly under a film grain. --}}
<section {{ $attributes->class('px-4 pt-16 sm:pt-20') }}>
    <div @class([
        'cta-gradient px-6 py-24 text-center sm:py-32 lg:py-40',
        'text-white' => ! $isLight,
        'text-neutral-900' => $isLight,
    ]) data-tone="{{ $tone }}">
        <div class="cta-gradient-field" aria-hidden="true">
            <span class="cta-gradient-blob cta-gradient-blob-deep"></span>
            <span class="cta-gradient-blob cta-gradient-blob-soft"></span>
            <span class="cta-gradient-blob cta-gradient-blob-light"></span>
        </div>
        <span class="cta-gradient-grain" aria-hidden="true"></span>

        <div class="relative mx-auto flex max-w-7xl flex-col items-center">
            <h2 class="max-w-2xl text-3xl font-semibold text-balance sm:text-4xl">{{ $heading }}</h2>

            @isset($text)
                <p @class(['mt-4 max-w-xl text-lg text-pretty', 'text-white/90' => ! $isLight, 'text-neutral-900/80' => $isLight])>{{ $text }}</p>
            @endisset

            <x-site.whatsapp-button
                @class(['mt-8', 'focus-visible:outline-white!' => ! $isLight, 'focus-visible:outline-neutral-900!' => $isLight])
                :message="$message"
            >
                {{ $button }}
            </x-site.whatsapp-button>

            @isset($aside)
                <p @class(['mt-5 text-sm', 'text-white/80' => ! $isLight, 'text-neutral-900/75' => $isLight])>{{ $aside }}</p>
            @endisset
        </div>
    </div>
</section>
