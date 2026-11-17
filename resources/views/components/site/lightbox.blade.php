{{--
    Photo lightbox. Lives inside a parent x-data that provides gallery, group, index,
    close() and step(direction), the same contract the Cursos page uses.
--}}
    <template x-teleport="body">
        <div
            x-show="group !== null"
            x-cloak
            x-transition.opacity.duration.250ms
            class="fixed inset-0 z-60 flex flex-col items-center justify-center bg-neutral-950/90 p-4 backdrop-blur-sm sm:p-10"
            x-on:click.self="close()"
            x-on:keydown.arrow-right.window="group !== null && step(1)"
            x-on:keydown.arrow-left.window="group !== null && step(-1)"
            role="dialog"
            aria-modal="true"
            aria-label="{{ __('Foto ampliada') }}"
        >
            <template x-if="group !== null">
                <figure class="flex max-h-full w-full max-w-5xl flex-col items-center" x-trap.noscroll="group !== null">
                    <img
                        x-bind:key="gallery[group][index].src"
                        x-bind:src="gallery[group][index].src"
                        x-bind:alt="gallery[group][index].alt"
                        class="max-h-[78svh] w-auto rounded-2xl object-contain"
                    >
                    <figcaption class="mt-4 text-center text-white">
                        <span class="block text-base font-medium sm:text-lg" x-text="gallery[group][index].alt"></span>
                        <span class="mt-1 block text-sm text-white/60 tabular-nums" x-text="(index + 1) + ' / ' + gallery[group].length"></span>
                    </figcaption>
                </figure>
            </template>

            <button type="button" x-on:click="close()" class="absolute top-4 right-4 grid size-11 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95" aria-label="{{ __('Cerrar') }}">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M1 1l12 12M13 1L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
            <template x-if="group !== null && gallery[group].length > 1">
                <div>
                    <button type="button" x-on:click="step(-1)" class="absolute top-1/2 left-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95 sm:left-6" aria-label="{{ __('Anterior') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true" class="rotate-180"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                    <button type="button" x-on:click="step(1)" class="absolute top-1/2 right-3 grid size-11 -translate-y-1/2 cursor-pointer place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20 active:scale-95 sm:right-6" aria-label="{{ __('Siguiente') }}">
                        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" aria-hidden="true"><path d="M1.41406 13.4141L7.41406 7.41406L1.41406 1.41406" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="round" /></svg>
                    </button>
                </div>
            </template>
        </div>
    </template>
