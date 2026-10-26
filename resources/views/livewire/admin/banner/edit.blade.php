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
            <flux:input type="file" wire:model="image" accept="image/*" label="Imagen de fondo" description="JPG o PNG, máximo 5 MB. Horizontal, de preferencia 1920 px de ancho." />

            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" alt="" class="aspect-video w-full rounded-lg object-cover">
            @elseif ($banner?->imageUrl())
                <img src="{{ $banner->imageUrl() }}" alt="" class="aspect-video w-full rounded-lg object-cover">
            @endif
        </div>

        <flux:button type="submit" variant="primary">Guardar</flux:button>
    </form>
</section>
