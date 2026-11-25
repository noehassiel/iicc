<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Reseñas')]
class Index extends Component
{
    use WithPagination;

    /**
     * @return LengthAwarePaginator<int, Review>
     */
    #[Computed]
    public function reviews(): LengthAwarePaginator
    {
        return Review::query()->latest()->paginate(20);
    }

    /**
     * Show or hide a review on the site.
     */
    public function togglePublished(Review $review): void
    {
        $review->update(['is_published' => ! $review->is_published]);
    }

    public function delete(Review $review): void
    {
        $review->delete();

        Flux::toast(variant: 'success', text: 'Reseña eliminada.');
    }

    public function render(): View
    {
        return view('livewire.admin.reviews.index');
    }
}
