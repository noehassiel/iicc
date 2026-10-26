<?php

namespace App\Models;

use Database\Factories\BannerSlideFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * One full-screen background of the home hero: an image or a muted looping video.
 *
 * @property int $id
 * @property int $banner_id
 * @property string $type
 * @property string $path
 * @property string|null $poster_path
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['type', 'path', 'poster_path', 'position'])]
class BannerSlide extends Model
{
    /** @use HasFactory<BannerSlideFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Banner, $this>
     */
    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    /**
     * Still image for the hero thumbnail: the poster for videos, the image itself otherwise.
     */
    public function thumbnailUrl(): ?string
    {
        if (! $this->isVideo()) {
            return $this->url();
        }

        return $this->poster_path ? Storage::disk('public')->url($this->poster_path) : null;
    }
}
