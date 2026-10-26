<section class="w-full max-w-3xl">
    <flux:heading size="xl" level="1">Banner principal</flux:heading>
    <flux:text class="mt-2">Lo que se ve al abrir la página de inicio.</flux:text>

    <form wire:submit="save" class="mt-8 space-y-8">
        <div class="grid gap-6 sm:grid-cols-2">
            <flux:input wire:model="title_es" label="Título (español)" required />
            <flux:input wire:model="title_zh" label="Título (中文)" lang="zh-Hant" />
            <flux:input wire:model="subtitle_es" label="Subtítulo (español)" />
            <flux:input wire:model="subtitle_zh" label="Subtítulo (中文)" lang="zh-Hant" />
            <flux:input wire:model="button_label_es" label="Texto del botón (español)" />
            <flux:input wire:model="button_label_zh" label="Texto del botón (中文)" lang="zh-Hant" />
        </div>

        <flux:input wire:model="button_url" type="url" label="Enlace del botón" description="Si lo dejas vacío, el botón abre WhatsApp." placeholder="https://" />

        <div class="space-y-3">
            <flux:input type="file" wire:model="media" accept="image/jpeg,image/png,image/webp,video/mp4,video/webm" multiple label="Agregar fondos" description="Imágenes (JPG, PNG, WebP) o videos cortos (MP4, WebM), máximo 12 MB cada uno. Horizontales, de preferencia 1920 px de ancho. Los videos se reproducen sin sonido y en bucle." />
            <flux:error name="media.*" />

            @if ($media)
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                    @foreach ($media as $index => $file)
                        <div class="relative" wire:key="upload-{{ $index }}">
                            @if (str_starts_with((string) $file->getMimeType(), 'image/'))
                                <img src="{{ $file->temporaryUrl() }}" alt="" class="aspect-video w-full rounded-lg object-cover opacity-70">
                            @else
                                <div class="flex aspect-video w-full items-center justify-center rounded-lg bg-zinc-800 p-2 text-center text-xs text-white/80">{{ $file->getClientOriginalName() }}</div>
                            @endif
                            <flux:button size="xs" variant="filled" icon="x-mark" class="absolute top-1 right-1" wire:click="removeUpload({{ $index }})" aria-label="Quitar" />
                        </div>
                    @endforeach
                </div>
                <flux:text>Se suben al guardar.</flux:text>
            @endif
        </div>

        <flux:button type="submit" variant="primary">Guardar</flux:button>
    </form>

    @if ($banner)
        <flux:separator class="my-10" />

        <flux:heading size="lg">Fondos ({{ $banner->slides->count() }})</flux:heading>
        <flux:text class="mt-2">El primero aparece al abrir la página; los demás se eligen con las miniaturas.</flux:text>

        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
            @forelse ($banner->slides as $slide)
                <div class="space-y-2" wire:key="slide-{{ $slide->id }}">
                    @if ($slide->isVideo())
                        <video src="{{ $slide->url() }}" poster="{{ $slide->thumbnailUrl() }}" muted loop playsinline preload="metadata" class="aspect-video w-full rounded-lg bg-zinc-800 object-cover" onmouseenter="this.play()" onmouseleave="this.pause()"></video>
                        <flux:input type="file" wire:model="posters.{{ $slide->id }}" accept="image/*" size="sm" :label="$slide->poster_path ? 'Cambiar miniatura' : 'Miniatura del video'" />
                        <flux:error name="posters.{{ $slide->id }}" />
                    @else
                        <img src="{{ $slide->url() }}" alt="" class="aspect-video w-full rounded-lg object-cover">
                    @endif
                    <div class="flex justify-between">
                        <div class="flex">
                            <flux:button size="xs" variant="ghost" icon="arrow-left" wire:click="moveSlide({{ $slide->id }}, -1)" :disabled="$loop->first" aria-label="Mover antes" />
                            <flux:button size="xs" variant="ghost" icon="arrow-right" wire:click="moveSlide({{ $slide->id }}, 1)" :disabled="$loop->last" aria-label="Mover después" />
                        </div>
                        <flux:button size="xs" variant="ghost" icon="trash" wire:click="deleteSlide({{ $slide->id }})" wire:confirm="¿Eliminar este fondo?" aria-label="Eliminar fondo" />
                    </div>
                </div>
            @empty
                <flux:text class="col-span-full">Aún no hay fondos.</flux:text>
            @endforelse
        </div>
    @endif
</section>
