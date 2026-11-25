{{-- Marks a photo taken during an online class. --}}
<span {{ $attributes->class('pointer-events-none absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-white/85 px-2.5 py-1 text-xs font-semibold text-neutral-900 shadow-sm backdrop-blur-sm') }}>
    <span class="course-live-dot size-1.5 rounded-full bg-brand-orange" aria-hidden="true"></span>
    {{ __('En línea') }}
</span>
