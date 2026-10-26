<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

#[Title('Banner principal')]
class Edit extends Component
{
    use WithFileUploads;

    public ?Banner $banner = null;

    public string $title_es = '';

    public string $title_zh = '';

    public string $subtitle_es = '';

    public string $subtitle_zh = '';

    public string $button_label_es = '';

    public string $button_label_zh = '';

    public string $button_url = '';

    /** @var UploadedFile|null */
    public $image = null;

    /**
     * Load the current banner into the form.
     */
    public function mount(): void
    {
        $this->banner = Banner::current();

        if ($this->banner) {
            $this->fill(array_map(strval(...), $this->banner->only([
                'title_es', 'title_zh', 'subtitle_es', 'subtitle_zh',
                'button_label_es', 'button_label_zh', 'button_url',
            ])));
        }
    }

    /**
     * Save the banner, replacing the background image if a new one was uploaded.
     */
    public function save(): void
    {
        $validated = $this->validate([
            'title_es' => ['required', 'string', 'max:255'],
            'title_zh' => ['nullable', 'string', 'max:255'],
            'subtitle_es' => ['nullable', 'string', 'max:255'],
            'subtitle_zh' => ['nullable', 'string', 'max:255'],
            'button_label_es' => ['nullable', 'required_with:button_url', 'string', 'max:255'],
            'button_label_zh' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($validated['image']);

        $banner = $this->banner ?? new Banner;
        $banner->fill($validated);

        if ($this->image) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $banner->image_path = $this->image->store('banners', 'public') ?: throw new RuntimeException('Could not store the banner image.');
        }

        $banner->save();

        $this->banner = $banner;
        $this->image = null;

        Flux::toast(variant: 'success', text: 'Banner guardado.');
    }

    public function render(): View
    {
        return view('livewire.admin.banner.edit');
    }
}
