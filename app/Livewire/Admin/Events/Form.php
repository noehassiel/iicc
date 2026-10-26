<?php

namespace App\Livewire\Admin\Events;

use App\Enums\EventCategory;
use App\Models\Event;
use App\Models\EventPhoto;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

class Form extends Component
{
    use WithFileUploads;

    public ?Event $event = null;

    public string $category = 'cultural';

    public string $slug = '';

    public string $title_es = '';

    public string $title_zh = '';

    public string $description_es = '';

    public string $description_zh = '';

    public string $date = '';

    /** @var UploadedFile|null */
    public $cover = null;

    /** @var array<int, UploadedFile> */
    public array $photos = [];

    /**
     * Load the event being edited, or start a blank one.
     */
    public function mount(?Event $event = null): void
    {
        if ($event?->exists) {
            $this->event = $event;
            $this->fill(array_map(strval(...), $event->only(['slug', 'title_es', 'title_zh', 'description_es', 'description_zh'])));
            $this->category = $event->category->value;
            $this->date = $event->date->toDateString();
        }
    }

    /**
     * Save the event, its cover and any newly uploaded gallery photos.
     */
    public function save(): void
    {
        $this->slug = Str::slug($this->slug ?: $this->title_es);

        $validated = $this->validate([
            'category' => ['required', Rule::enum(EventCategory::class)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('events')->ignore($this->event)],
            'title_es' => ['required', 'string', 'max:255'],
            'title_zh' => ['nullable', 'string', 'max:255'],
            'description_es' => ['nullable', 'string', 'max:5000'],
            'description_zh' => ['nullable', 'string', 'max:5000'],
            'date' => ['required', 'date'],
            'cover' => ['nullable', 'image', 'max:5120'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        unset($validated['cover'], $validated['photos']);

        $event = $this->event ?? new Event;
        $event->fill($validated);

        if ($this->cover) {
            if ($event->cover_path) {
                Storage::disk('public')->delete($event->cover_path);
            }

            $event->cover_path = $this->cover->store('events', 'public') ?: throw new RuntimeException('Could not store the event cover.');
        }

        $event->save();

        $position = (int) $event->photos()->max('position');

        foreach ($this->photos as $photo) {
            $event->photos()->create([
                'path' => $photo->store("events/{$event->id}", 'public') ?: throw new RuntimeException('Could not store the gallery photo.'),
                'position' => ++$position,
            ]);
        }

        Flux::toast(variant: 'success', text: 'Evento guardado.');

        $this->redirectRoute('admin.events.edit', $event, navigate: true);
    }

    /**
     * Move a gallery photo one place earlier or later.
     */
    public function movePhoto(EventPhoto $photo, int $direction): void
    {
        abort_unless($photo->event_id === $this->event?->id, 404);

        $photos = $this->event->photos()->get()->values();
        $index = $photos->search(fn (EventPhoto $item) => $item->is($photo));
        $swap = $photos->get($index + $direction);

        if ($index === false || ! $swap) {
            return;
        }

        $photos->splice($index, 1);
        $photos->splice($index + $direction, 0, [$photo]);
        $photos->each(fn (EventPhoto $item, int $position) => $item->update(['position' => $position]));
    }

    public function deletePhoto(EventPhoto $photo): void
    {
        abort_unless($photo->event_id === $this->event?->id, 404);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();
    }

    public function removeUpload(int $index): void
    {
        array_splice($this->photos, $index, 1);
    }

    public function render(): View
    {
        return view('livewire.admin.events.form')
            ->title($this->event ? 'Editar evento' : 'Nuevo evento');
    }
}
