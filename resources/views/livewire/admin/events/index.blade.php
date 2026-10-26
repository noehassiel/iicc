<section class="w-full">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl" level="1">Eventos</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('admin.events.create')" wire:navigate>Nuevo evento</flux:button>
    </div>

    <div class="mt-6 max-w-xs">
        <flux:select wire:model.live="category" aria-label="Filtrar por sección">
            <flux:select.option value="">Todas las secciones</flux:select.option>
            @foreach (App\Enums\EventCategory::cases() as $option)
                <flux:select.option value="{{ $option->value }}">{{ $option->label() }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <flux:table :paginate="$this->events" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Evento</flux:table.column>
            <flux:table.column class="max-sm:hidden">Sección</flux:table.column>
            <flux:table.column class="max-sm:hidden">Fecha</flux:table.column>
            <flux:table.column class="max-sm:hidden">Fotos</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->events as $event)
                <flux:table.row :key="$event->id">
                    <flux:table.cell>
                        <a href="{{ route('admin.events.edit', $event) }}" wire:navigate class="flex items-center gap-3">
                            @if ($event->coverUrl())
                                <img src="{{ $event->coverUrl() }}" alt="" class="size-10 shrink-0 rounded object-cover">
                            @else
                                <div class="size-10 shrink-0 rounded bg-zinc-100 dark:bg-zinc-700"></div>
                            @endif
                            <span class="font-medium text-zinc-800 dark:text-white">{{ $event->title_es }}</span>
                        </a>
                    </flux:table.cell>
                    <flux:table.cell class="max-sm:hidden"><flux:badge size="sm">{{ $event->category->label() }}</flux:badge></flux:table.cell>
                    <flux:table.cell class="max-sm:hidden">{{ $event->date->format('d/m/Y') }}</flux:table.cell>
                    <flux:table.cell class="max-sm:hidden">{{ $event->photos_count }}</flux:table.cell>
                    <flux:table.cell align="end">
                        <flux:dropdown align="end">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Acciones" />
                            <flux:menu>
                                <flux:menu.item icon="pencil-square" :href="route('admin.events.edit', $event)" wire:navigate>Editar</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $event->id }})" wire:confirm="¿Eliminar «{{ $event->title_es }}» y todas sus fotos?">Eliminar</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center">Aún no hay eventos.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</section>
