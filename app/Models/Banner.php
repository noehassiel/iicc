<?php

namespace App\Models;

use App\Concerns\HasLocalizedAttributes;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title_es
 * @property string|null $title_zh
 * @property string|null $subtitle_es
 * @property string|null $subtitle_zh
 * @property string|null $button_label_es
 * @property string|null $button_label_zh
 * @property string|null $button_url
 * @property string|null $image_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title_es', 'title_zh', 'subtitle_es', 'subtitle_zh', 'button_label_es', 'button_label_zh', 'button_url', 'image_path'])]
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
     * Public URL of the background image, if one was uploaded.
     */
    public function imageUrl(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
