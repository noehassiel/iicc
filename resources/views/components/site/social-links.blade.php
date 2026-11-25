@props(['onDark' => false])

{{-- Instagram and Facebook as real buttons, used wherever the copy invites people to follow IICC. --}}
<div {{ $attributes->class('flex flex-wrap items-center gap-3') }}>
    <span @class(['text-sm', 'text-white/85' => $onDark, 'text-neutral-600' => ! $onDark])>{{ __('Síguenos en') }}</span>
    <a href="{{ config('site.instagram') }}" target="_blank" rel="noopener" @class([
        'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition hover:brightness-110',
        'bg-white text-neutral-900' => $onDark,
        'bg-linear-to-r from-[#F58529] via-[#DD2A7B] to-[#8134AF] text-white' => ! $onDark,
    ])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".5" fill="currentColor"/></svg>
        Instagram
    </a>
    <a href="{{ config('site.facebook') }}" target="_blank" rel="noopener" @class([
        'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition hover:brightness-110',
        'bg-white text-neutral-900' => $onDark,
        'bg-[#1877F2] text-white' => ! $onDark,
    ])>
        <svg viewBox="0 0 24 24" fill="currentColor" class="size-4" aria-hidden="true"><path d="M14 8.5V6.8c0-.8.2-1.3 1.4-1.3H17V2.3A22 22 0 0 0 14.6 2C12.2 2 10.6 3.5 10.6 6.2v2.3H8v3.6h2.6V22H14v-9.9h2.7l.4-3.6Z"/></svg>
        Facebook
    </a>
</div>
