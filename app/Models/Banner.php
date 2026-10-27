<?php

namespace App\Models;

use App\Concerns\HasLocalizedAttributes;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * One slide of the home hero: its own copy, button and image or video background.
 *
 * @property int $id
 * @property string $title_es
 * @property string|null $title_zh
 * @property string|null $subtitle_es
 * @property string|null $subtitle_zh
 * @property string|null $button_label_es
 * @property string|null $button_label_zh
 * @property string|null $button_url
 * @property string $media_type
 * @property string|null $media_path
 * @property string|null $poster_path
 * @property bool $is_active
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title_es', 'title_zh', 'subtitle_es', 'subtitle_zh', 'button_label_es', 'button_label_zh', 'button_url', 'media_type', 'media_path', 'poster_path', 'is_active', 'position'])]
class Banner extends Model
{
    /** @use HasFactory<BannerFactory> */
    use HasFactory, HasLocalizedAttributes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'position' => 'integer',
        ];
    }

    /**
     * Active banners in display order; the first one opens the home page.
     *
     * @return Collection<int, self>
     */
    public static function active(): Collection
    {
        return self::query()->where('is_active', true)->orderBy('position')->orderBy('id')->get();
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    public function mediaUrl(): ?string
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    /**
     * Still image for the hero thumbnail: the poster for videos, the image itself otherwise.
     */
    public function thumbnailUrl(): ?string
    {
        if (! $this->isVideo()) {
            return $this->mediaUrl();
        }

        return $this->poster_path ? Storage::disk('public')->url($this->poster_path) : null;
    }
}
