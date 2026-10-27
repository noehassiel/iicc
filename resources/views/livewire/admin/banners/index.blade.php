<section class="w-full">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl" level="1">Banners</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('admin.banners.create')" wire:navigate>Nuevo banner</flux:button>
    </div>

    <flux:text class="mt-2">Se muestran en la portada todos los banners activos, en este orden. El primero aparece al abrir la página; los demás se eligen con las miniaturas.</flux:text>

    <flux:table class="mt-6">
        <flux:table.columns>
            <flux:table.column>Banner</flux:table.column>
            <flux:table.column class="max-sm:hidden">Orden</flux:table.column>
            <flux:table.column>Activo</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->banners as $banner)
                <flux:table.row :key="$banner->id">
                    <flux:table.cell class="max-w-md whitespace-normal">
                        <a href="{{ route('admin.banners.edit', $banner) }}" wire:navigate class="flex items-center gap-3">
                            @if ($banner->thumbnailUrl())
                                <img src="{{ $banner->thumbnailUrl() }}" alt="" class="aspect-video w-24 shrink-0 rounded object-cover">
                            @else
                                <span class="flex aspect-video w-24 shrink-0 items-center justify-center rounded bg-zinc-800 text-xs text-white/70">{{ $banner->isVideo() ? 'Video' : 'Sin fondo' }}</span>
                            @endif
                            <span>
                                <span class="block font-medium text-zinc-800 dark:text-white">{{ $banner->title_es }}</span>
                                @if ($banner->subtitle_es)
                                    <span class="mt-1 line-clamp-1 text-zinc-500">{{ $banner->subtitle_es }}</span>
                                @endif
                            </span>
                        </a>
                    </flux:table.cell>
                    <flux:table.cell class="max-sm:hidden">
                        <div class="flex">
                            <flux:button size="xs" variant="ghost" icon="arrow-up" wire:click="move({{ $banner->id }}, -1)" :disabled="$loop->first" aria-label="Mover antes" />
                            <flux:button size="xs" variant="ghost" icon="arrow-down" wire:click="move({{ $banner->id }}, 1)" :disabled="$loop->last" aria-label="Mover después" />
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:switch :checked="$banner->is_active" wire:click="toggleActive({{ $banner->id }})" aria-label="Activo" />
                    </flux:table.cell>
                    <flux:table.cell align="end">
                        <flux:dropdown align="end">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Acciones" />
                            <flux:menu>
                                <flux:menu.item icon="pencil-square" :href="route('admin.banners.edit', $banner)" wire:navigate>Editar</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $banner->id }})" wire:confirm="¿Eliminar este banner?">Eliminar</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center">Aún no hay banners.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</section>
