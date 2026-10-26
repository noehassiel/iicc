<?php

namespace App\Models;

use App\Concerns\HasLocalizedAttributes;
use App\Enums\EventCategory;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property EventCategory $category
 * @property string $slug
 * @property string $title_es
 * @property string|null $title_zh
 * @property string|null $description_es
 * @property string|null $description_zh
 * @property Carbon $date
 * @property string|null $cover_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['category', 'slug', 'title_es', 'title_zh', 'description_es', 'description_zh', 'date', 'cover_path'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory, HasLocalizedAttributes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => EventCategory::class,
            'date' => 'date',
        ];
    }

    /**
     * @return HasMany<EventPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(EventPhoto::class)->orderBy('position');
    }

    /**
     * Public URL of the cover picture, if one was uploaded.
     */
    public function coverUrl(): ?string
    {
        return $this->cover_path ? Storage::disk('public')->url($this->cover_path) : null;
    }

    /**
     * Date as shown on the public site: only the year for "Nuestra Huella" events.
     */
    public function displayDate(): string
    {
        return $this->category === EventCategory::Huella
            ? $this->date->format('Y')
            : $this->date->translatedFormat('j \d\e F \d\e Y');
    }
}
