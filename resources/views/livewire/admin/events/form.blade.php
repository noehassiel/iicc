<section class="w-full max-w-3xl">
    <flux:button variant="ghost" size="sm" icon="arrow-left" :href="route('admin.events.index')" wire:navigate inset="left">Eventos</flux:button>

    <flux:heading size="xl" level="1" class="mt-2">{{ $event ? 'Editar evento' : 'Nuevo evento' }}</flux:heading>

    <form wire:submit="save" class="mt-8 space-y-8">
        <div class="grid gap-6 sm:grid-cols-2">
            <flux:select wire:model="category" label="Sección">
                @foreach (App\Enums\EventCategory::cases() as $option)
                    <flux:select.option value="{{ $option->value }}">{{ $option->label() }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input wire:model="date" type="date" label="Fecha" description="En «Nuestra Huella» solo se muestra el año." required />
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <flux:input wire:model="title_es" label="Título (español)" required />
            <flux:input wire:model="title_zh" label="Título (中文)" lang="zh-Hant" />
            <flux:textarea wire:model="description_es" label="Descripción (español)" rows="5" />
            <flux:textarea wire:model="description_zh" label="Descripción (中文)" rows="5" lang="zh-Hant" />
        </div>

        <flux:input wire:model="slug" label="Identificador" description="Se genera del título si lo dejas vacío." />

        <div class="space-y-3">
            <flux:input type="file" wire:model="cover" accept="image/*" label="Foto de portada" description="JPG o PNG, máximo 5 MB." />

            @if ($cover)
                <img src="{{ $cover->temporaryUrl() }}" alt="" class="aspect-[4/3] w-full max-w-sm rounded-lg object-cover">
            @elseif ($event?->coverUrl())
                <img src="{{ $event->coverUrl() }}" alt="" class="aspect-[4/3] w-full max-w-sm rounded-lg object-cover">
            @endif
        </div>

        <div class="space-y-3">
            <flux:input type="file" wire:model="photos" accept="image/*" multiple label="Agregar fotos a la galería" description="Puedes elegir varias a la vez. Máximo 5 MB cada una." />
            <flux:error name="photos.*" />

            @if ($photos)
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                    @foreach ($photos as $index => $photo)
                        <div class="relative" wire:key="upload-{{ $index }}">
                            <img src="{{ $photo->temporaryUrl() }}" alt="" class="aspect-square w-full rounded-lg object-cover opacity-70">
                            <flux:button size="xs" variant="filled" icon="x-mark" class="absolute top-1 right-1" wire:click="removeUpload({{ $index }})" aria-label="Quitar" />
                        </div>
                    @endforeach
                </div>
                <flux:text>Se suben al guardar.</flux:text>
            @endif
        </div>

        <flux:button type="submit" variant="primary">Guardar</flux:button>
    </form>

    @if ($event)
        <flux:separator class="my-10" />

        <flux:heading size="lg">Galería ({{ $event->photos->count() }})</flux:heading>

        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @forelse ($event->photos as $photo)
                <div class="space-y-2" wire:key="photo-{{ $photo->id }}">
                    <img src="{{ $photo->url() }}" alt="" class="aspect-square w-full rounded-lg object-cover">
                    <div class="flex justify-between">
                        <div class="flex">
                            <flux:button size="xs" variant="ghost" icon="arrow-left" wire:click="movePhoto({{ $photo->id }}, -1)" :disabled="$loop->first" aria-label="Mover antes" />
                            <flux:button size="xs" variant="ghost" icon="arrow-right" wire:click="movePhoto({{ $photo->id }}, 1)" :disabled="$loop->last" aria-label="Mover después" />
                        </div>
                        <flux:button size="xs" variant="ghost" icon="trash" wire:click="deletePhoto({{ $photo->id }})" wire:confirm="¿Eliminar esta foto?" aria-label="Eliminar foto" />
                    </div>
                </div>
            @empty
                <flux:text class="col-span-full">Este evento aún no tiene fotos.</flux:text>
            @endforelse
        </div>
    @endif
</section>
