<?php

namespace App\Concerns;

use Illuminate\Support\Facades\App;

/**
 * Reads bilingual columns stored as `{attribute}_es` / `{attribute}_zh`.
 */
trait HasLocalizedAttributes
{
    /**
     * Get the attribute in the current site language, falling back to Spanish.
     */
    public function localized(string $attribute): ?string
    {
        if (App::getLocale() === 'zh_TW' && filled($this->{$attribute.'_zh'})) {
            return $this->{$attribute.'_zh'};
        }

        return $this->{$attribute.'_es'};
    }
}
