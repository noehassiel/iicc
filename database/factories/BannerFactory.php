<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_es' => fake()->sentence(4),
            'title_zh' => '學華語，認識中華文化',
            'subtitle_es' => fake()->sentence(),
            'subtitle_zh' => '墨西哥中華文化學院',
            'button_label_es' => 'Comienza ahora',
            'button_label_zh' => '立即開始',
            'button_url' => 'https://wa.me/'.config('site.whatsapp'),
        ];
    }
}
