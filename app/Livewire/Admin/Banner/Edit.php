<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use App\Models\BannerSlide;
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

    /** @var array<int, UploadedFile> */
    public array $media = [];

    /** @var array<int, UploadedFile> Poster uploads for video slides, keyed by slide id. */
    public array $posters = [];

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
     * Save the banner and append any newly uploaded backgrounds as slides.
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
            'media.*' => ['file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:12288'],
        ]);

        unset($validated['media']);

        $banner = $this->banner ?? new Banner;
        $banner->fill($validated)->save();

        $position = (int) $banner->slides()->max('position');

        foreach ($this->media as $file) {
            $banner->slides()->create([
                'type' => str_starts_with((string) $file->getMimeType(), 'video/') ? 'video' : 'image',
                'path' => $file->store('banners', 'public') ?: throw new RuntimeException('Could not store the banner background.'),
                'position' => ++$position,
            ]);
        }

        $this->banner = $banner;
        $this->media = [];

        Flux::toast(variant: 'success', text: 'Banner guardado.');
    }

    /**
     * Store a poster as soon as it is picked for a video slide.
     */
    public function updatedPosters(mixed $file, string $slideId): void
    {
        $this->validate(["posters.{$slideId}" => ['image', 'max:5120']]);

        $slide = $this->ownSlide((int) $slideId);

        if ($slide->poster_path) {
            Storage::disk('public')->delete($slide->poster_path);
        }

        $slide->update([
            'poster_path' => $this->posters[$slideId]->store('banners', 'public') ?: throw new RuntimeException('Could not store the poster.'),
        ]);

        unset($this->posters[$slideId]);
    }

    /**
     * Move a slide one place earlier or later.
     */
    public function moveSlide(int $slideId, int $direction): void
    {
        $slide = $this->ownSlide($slideId);

        $slides = $this->banner->slides()->get()->values();
        $index = $slides->search(fn (BannerSlide $item) => $item->is($slide));

        if ($index === false || ! $slides->get($index + $direction)) {
            return;
        }

        $slides->splice($index, 1);
        $slides->splice($index + $direction, 0, [$slide]);
        $slides->each(fn (BannerSlide $item, int $position) => $item->update(['position' => $position]));
    }

    public function deleteSlide(int $slideId): void
    {
        $slide = $this->ownSlide($slideId);

        Storage::disk('public')->delete(array_filter([$slide->path, $slide->poster_path]));
        $slide->delete();
    }

    public function removeUpload(int $index): void
    {
        array_splice($this->media, $index, 1);
    }

    private function ownSlide(int $slideId): BannerSlide
    {
        abort_if($this->banner === null, 404);

        return $this->banner->slides()->findOrFail($slideId);
    }

    public function render(): View
    {
        return view('livewire.admin.banner.edit');
    }
}
