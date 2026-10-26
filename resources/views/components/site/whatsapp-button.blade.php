@props(['message' => null])

<a
    href="https://wa.me/{{ config('site.whatsapp') }}{{ $message ? '?text='.rawurlencode($message) : '' }}"
    target="_blank"
    rel="noopener"
    data-button-06
    {{ $attributes }}
>
    <span class="surface" data-surface aria-hidden="true"></span>
    <span class="label">{{ $slot }}</span>
    <span class="arrow" data-arrow aria-hidden="true">
        <svg viewBox="0 0 16 16" fill="none" focusable="false">
            <path d="M3 13 13 3M3 3h10v10"></path>
        </svg>
    </span>
</a>
