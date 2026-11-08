<section class="w-full max-w-3xl">
    <flux:button variant="ghost" size="sm" icon="arrow-left" :href="route('admin.banners.index')" wire:navigate inset="left">Banners</flux:button>

    <flux:heading size="xl" level="1" class="mt-2">{{ $banner ? 'Editar banner' : 'Nuevo banner' }}</flux:heading>

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
            <flux:input type="file" wire:model="media" accept="image/jpeg,image/png,image/webp,video/mp4,video/webm" label="Fondo" description="Imagen (JPG, PNG, WebP) o video corto (MP4, WebM), máximo 12 MB. Horizontal, de preferencia 1920 px de ancho. Los videos se reproducen sin sonido y en bucle." />

            @if ($media && str_starts_with((string) $media->getMimeType(), 'image/'))
                <img src="{{ $media->temporaryUrl() }}" alt="" class="aspect-video w-full rounded-lg object-cover">
            @elseif ($media)
                <flux:text>{{ $media->getClientOriginalName() }} se sube al guardar.</flux:text>
            @elseif ($banner?->isVideo() && $banner->mediaUrl())
                <video src="{{ $banner->mediaUrl() }}" poster="{{ $banner->thumbnailUrl() }}" muted loop playsinline autoplay class="aspect-video w-full rounded-lg bg-zinc-800 object-cover"></video>
            @elseif ($banner?->mediaUrl())
                <img src="{{ $banner->mediaUrl() }}" alt="" class="aspect-video w-full rounded-lg object-cover">
            @endif
        </div>

        @if (($media && str_starts_with((string) $media->getMimeType(), 'video/')) || (! $media && $banner?->isVideo()))
            <div class="space-y-3">
                <flux:input type="file" wire:model="poster" accept="image/*" label="Miniatura del video" description="Imagen fija que se ve en las miniaturas y mientras carga el video." />

                @if ($poster)
                    <img src="{{ $poster->temporaryUrl() }}" alt="" class="aspect-video w-48 rounded-lg object-cover">
                @elseif ($banner?->poster_path)
                    <img src="{{ $banner->thumbnailUrl() }}" alt="" class="aspect-video w-48 rounded-lg object-cover">
                @endif
            </div>
        @endif

        <flux:switch wire:model="is_active" label="Mostrar en la portada" />

        <flux:button type="submit" variant="primary">Guardar</flux:button>
    </form>
</section>
