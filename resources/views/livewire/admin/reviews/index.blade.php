<section class="w-full">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl" level="1">Reseñas de Google</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('admin.reviews.create')" wire:navigate>Nueva reseña</flux:button>
    </div>

    <flux:text class="mt-2">En la página de inicio se muestran hasta 4 reseñas publicadas de {{ App\Models\Review::MINIMUM_RATING }} estrellas o más, en orden aleatorio.</flux:text>

    <flux:table :paginate="$this->reviews" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Reseña</flux:table.column>
            <flux:table.column class="max-sm:hidden">Estrellas</flux:table.column>
            <flux:table.column>Publicada</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($this->reviews as $review)
                <flux:table.row :key="$review->id">
                    <flux:table.cell class="max-w-md whitespace-normal">
                        <a href="{{ route('admin.reviews.edit', $review) }}" wire:navigate class="block">
                            <span class="font-medium text-zinc-800 dark:text-white">{{ $review->author }}</span>
                            <span class="mt-1 line-clamp-2 text-zinc-500">{{ $review->text }}</span>
                        </a>
                    </flux:table.cell>
                    <flux:table.cell class="max-sm:hidden whitespace-nowrap text-amber-500">{{ str_repeat('★', $review->rating) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:switch :checked="$review->is_published" wire:click="togglePublished({{ $review->id }})" aria-label="Publicada" />
                    </flux:table.cell>
                    <flux:table.cell align="end">
                        <flux:dropdown align="end">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Acciones" />
                            <flux:menu>
                                <flux:menu.item icon="pencil-square" :href="route('admin.reviews.edit', $review)" wire:navigate>Editar</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $review->id }})" wire:confirm="¿Eliminar la reseña de {{ $review->author }}?">Eliminar</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center">Aún no hay reseñas.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</section>
