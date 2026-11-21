<?php

namespace App\Livewire\Admin\Banners;

use App\Models\Banner;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Banners')]
class Index extends Component
{
    /**
     * @return Collection<int, Banner>
     */
    #[Computed]
    public function banners(): Collection
    {
        return Banner::query()->orderBy('position')->orderBy('id')->get();
    }

    /**
     * Show or hide a banner on the home page.
     */
    public function toggleActive(Banner $banner): void
    {
        $banner->update(['is_active' => ! $banner->is_active]);
    }

    /**
     * Move a banner one place earlier or later.
     */
    public function move(Banner $banner, int $direction): void
    {
        $banners = $this->banners()->values();
        $index = $banners->search(fn (Banner $item) => $item->is($banner));

        if ($index === false || ! $banners->get($index + $direction)) {
            return;
        }

        $banners->splice($index, 1);
        $banners->splice($index + $direction, 0, [$banner]);
        $banners->each(fn (Banner $item, int $position) => $item->update(['position' => $position]));
    }

    public function delete(Banner $banner): void
    {
        Storage::disk('public')->delete(array_filter([$banner->media_path, $banner->poster_path]));
        $banner->delete();

        Flux::toast(variant: 'success', text: 'Banner eliminado.');
    }

    public function render(): View
    {
        return view('livewire.admin.banners.index');
    }
}
