<?php

namespace App\Models;

use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * A Google review captured by hand from the admin panel. Shown as written (not translated).
 *
 * @property int $id
 * @property string $author
 * @property int $rating
 * @property string $text
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['author', 'rating', 'text', 'is_published'])]
class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory;

    /**
     * Minimum stars a review needs to appear on the site.
     */
    public const MINIMUM_RATING = 4;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Up to four published, well-rated reviews in random order for the home page.
     *
     * @return Collection<int, self>
     */
    public static function featured(int $limit = 4): Collection
    {
        return self::query()
            ->where('is_published', true)
            ->where('rating', '>=', self::MINIMUM_RATING)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
