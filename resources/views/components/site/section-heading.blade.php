@props(['eyebrow' => null])

<div {{ $attributes->class('max-w-2xl') }}>
    @if ($eyebrow)
        <p class="text-sm font-semibold uppercase tracking-wider text-brand-blue">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 text-2xl font-semibold text-balance sm:text-3xl">{{ $slot }}</h2>
</div>
