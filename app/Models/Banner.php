<?php

namespace App\Models;

use App\Concerns\HasLocalizedAttributes;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title_es
 * @property string|null $title_zh
 * @property string|null $subtitle_es
 * @property string|null $subtitle_zh
 * @property string|null $button_label_es
 * @property string|null $button_label_zh
 * @property string|null $button_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, BannerSlide> $slides
 */
#[Fillable(['title_es', 'title_zh', 'subtitle_es', 'subtitle_zh', 'button_label_es', 'button_label_zh', 'button_url'])]
class Banner extends Model
{
    /** @use HasFactory<BannerFactory> */
    use HasFactory, HasLocalizedAttributes;

    /**
     * The home page shows a single banner: the most recently saved one.
     */
    public static function current(): ?self
    {
        return static::query()->latest('id')->first();
    }

    /**
     * Full-screen backgrounds of the hero, in display order.
     *
     * @return HasMany<BannerSlide, $this>
     */
    public function slides(): HasMany
    {
        return $this->hasMany(BannerSlide::class)->orderBy('position');
    }
}
