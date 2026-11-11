@props(['group', 'photos'])

{{--
    Horizontal, swipeable strip of class photos. Each photo opens the page's
    lightbox through the parent's show(group, index).
--}}
<div
    x-data="{
        thumbWidth: 100,
        thumbOffset: 0,
        atStart: true,
        atEnd: false,
        measure() {
            const track = this.$refs.track;
            const overflow = track.scrollWidth - track.clientWidth;
            this.thumbWidth = (track.clientWidth / track.scrollWidth) * 100;
            this.thumbOffset = overflow > 0 ? (track.scrollLeft / overflow) * (100 / this.thumbWidth - 1) * 100 : 0;
            this.atStart = track.scrollLeft <= 4;
            this.atEnd = track.scrollLeft >= overflow - 4;
        },
        page(direction) {
            this.$refs.track.scrollBy({ left: direction * this.$refs.track.clientWidth * 0.8, behavior: 'smooth' });
        },
    }"
    x-init="$nextTick(() => measure())"
    x-on:resize.window.debounce.150ms="measure()"
    {{ $attributes->class('course-rail-reveal') }}
>
    <ul
        x-ref="track"
        x-on:scroll.passive="measure()"
        class="-mx-4 flex snap-x snap-mandatory scroll-px-4 gap-3 overflow-x-auto px-4 [scrollbar-width:none] sm:gap-4 [&::-webkit-scrollbar]:hidden"
        aria-label="{{ __('Fotos de clase') }}"
    >
        @foreach ($photos as $photo)
            <li class="w-[80%] shrink-0 snap-start sm:w-[46%] lg:w-[31.5%]">
                <button
                    type="button"
                    x-on:click="show('{{ $group }}', {{ $loop->index }})"
                    class="group relative block w-full cursor-zoom-in overflow-hidden rounded-2xl bg-neutral-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue"
                    aria-label="{{ __('Ampliar foto') }}: {{ $photo['alt'] }}"
                >
                    <img src="{{ $photo['src'] }}" alt="" loading="lazy" decoding="async" class="aspect-4/3 w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:scale-[1.04]">
                    @if ($photo['online'])
                        <x-site.online-tag />
                    @endif
                </button>
            </li>
        @endforeach
    </ul>

    <div class="mt-4 flex items-center gap-4">
        <div class="h-0.5 flex-1 overflow-hidden rounded-full bg-neutral-200" aria-hidden="true">
            <div class="h-full rounded-full bg-brand-blue transition-transform duration-150 ease-out" x-bind:style="`width: ${thumbWidth}%; transform: translateX(${thumbOffset}%)`"></div>
        </div>
        <div class="flex gap-2">
            <button type="button" x-on:click="page(-1)" x-bind:disabled="atStart" class="grid size-10 cursor-pointer place-items-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition hover:border-neutral-400 active:scale-95 disabled:cursor-default disabled:opacity-40 disabled:hover:border-neutral-200" aria-label="{{ __('Anterior') }}">
                <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true" class="rotate-180"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
            </button>
            <button type="button" x-on:click="page(1)" x-bind:disabled="atEnd" class="grid size-10 cursor-pointer place-items-center rounded-full border border-neutral-200 bg-white text-neutral-900 transition hover:border-neutral-400 active:scale-95 disabled:cursor-default disabled:opacity-40 disabled:hover:border-neutral-200" aria-label="{{ __('Siguiente') }}">
                <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
            </button>
        </div>
    </div>
</div>
