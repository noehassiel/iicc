<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Form extends Component
{
    public ?Review $review = null;

    public string $author = '';

    public int $rating = 5;

    public string $text_es = '';

    public string $text_zh = '';

    public bool $is_published = true;

    /**
     * Load the review being edited, or start a blank one.
     */
    public function mount(?Review $review = null): void
    {
        if ($review?->exists) {
            $this->review = $review;
            $this->fill([...$review->only(['author', 'rating', 'text_es', 'is_published']), 'text_zh' => (string) $review->text_zh]);
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'author' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'text_es' => ['required', 'string', 'max:2000'],
            'text_zh' => ['nullable', 'string', 'max:2000'],
            'is_published' => ['boolean'],
        ]);

        $review = $this->review ?? new Review;
        $review->fill($validated)->save();

        Flux::toast(variant: 'success', text: 'Reseña guardada.');

        $this->redirectRoute('admin.reviews.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.reviews.form')
            ->title($this->review ? 'Editar reseña' : 'Nueva reseña');
    }
}
