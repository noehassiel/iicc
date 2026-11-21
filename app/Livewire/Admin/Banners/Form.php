<?php

namespace App\Livewire\Admin\Banners;

use App\Models\Banner;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

class Form extends Component
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

    public bool $is_active = true;

    /** @var UploadedFile|null Image or video background. */
    public $media = null;

    /** @var UploadedFile|null Still image shown for a video background. */
    public $poster = null;

    /**
     * Load the banner being edited, or start a blank one.
     */
    public function mount(?Banner $banner = null): void
    {
        if ($banner?->exists) {
            $this->banner = $banner;
            $this->fill([
                ...array_map(strval(...), $banner->only([
                    'title_es', 'title_zh', 'subtitle_es', 'subtitle_zh',
                    'button_label_es', 'button_label_zh', 'button_url',
                ])),
                'is_active' => $banner->is_active,
            ]);
        }
    }

    /**
     * Save the banner, replacing its background or poster if new ones were uploaded.
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
            'is_active' => ['boolean'],
            'media' => [$this->banner?->media_path ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:12288'],
            'poster' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($validated['media'], $validated['poster']);

        $banner = $this->banner ?? new Banner(['position' => (int) Banner::query()->max('position') + 1]);
        $banner->fill($validated);

        if ($this->media) {
            Storage::disk('public')->delete(array_filter([$banner->media_path, $this->poster ? null : $banner->poster_path]));

            $banner->media_type = str_starts_with((string) $this->media->getMimeType(), 'video/') ? 'video' : 'image';
            $banner->media_path = $this->media->store('banners', 'public') ?: throw new RuntimeException('Could not store the banner background.');

            if (! $banner->isVideo()) {
                $banner->poster_path = null;
            }
        }

        if ($this->poster) {
            if ($banner->poster_path) {
                Storage::disk('public')->delete($banner->poster_path);
            }

            $banner->poster_path = $this->poster->store('banners', 'public') ?: throw new RuntimeException('Could not store the poster.');
        }

        $banner->save();

        Flux::toast(variant: 'success', text: 'Banner guardado.');

        $this->redirectRoute('admin.banners.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.banners.form')
            ->title($this->banner ? 'Editar banner' : 'Nuevo banner');
    }
}
