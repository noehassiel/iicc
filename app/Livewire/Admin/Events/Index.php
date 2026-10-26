<?php

namespace App\Livewire\Admin\Events;

use App\Enums\EventCategory;
use App\Models\Event;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Eventos')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    /**
     * @return LengthAwarePaginator<int, Event>
     */
    #[Computed]
    public function events(): LengthAwarePaginator
    {
        return Event::query()
            ->withCount('photos')
            ->when(EventCategory::tryFrom($this->category), fn ($query, EventCategory $category) => $query->where('category', $category))
            ->latest('date')
            ->paginate(15);
    }

    /**
     * Delete an event along with its cover and gallery files.
     */
    public function delete(Event $event): void
    {
        Storage::disk('public')->delete(array_filter([
            $event->cover_path,
            ...$event->photos->pluck('path'),
        ]));

        $event->delete();

        Flux::toast(variant: 'success', text: 'Evento eliminado.');
    }

    public function render(): View
    {
        return view('livewire.admin.events.index');
    }
}
