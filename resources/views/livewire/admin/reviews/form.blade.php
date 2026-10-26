<section class="w-full max-w-2xl">
    <flux:button variant="ghost" size="sm" icon="arrow-left" :href="route('admin.reviews.index')" wire:navigate inset="left">Reseñas</flux:button>

    <flux:heading size="xl" level="1" class="mt-2">{{ $review ? 'Editar reseña' : 'Nueva reseña' }}</flux:heading>
    <flux:text class="mt-2">Copia la reseña tal como aparece en Google Maps. Se muestra igual en español y en chino.</flux:text>

    <form wire:submit="save" class="mt-8 space-y-6">
        <flux:input wire:model="author" label="Nombre de quien la escribió" required />

        <flux:select wire:model="rating" label="Estrellas">
            @foreach (range(5, 1) as $stars)
                <flux:select.option :value="$stars">{{ str_repeat('★', $stars) }} ({{ $stars }})</flux:select.option>
            @endforeach
        </flux:select>

        <flux:textarea wire:model="text" label="Texto de la reseña" rows="6" required />

        <flux:switch wire:model="is_published" label="Mostrar en el sitio" description="Solo se muestran las de {{ App\Models\Review::MINIMUM_RATING }} estrellas o más." />

        <flux:button type="submit" variant="primary">Guardar</flux:button>
    </form>
</section>
