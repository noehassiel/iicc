<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\BannerSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BannerSlide>
 */
class BannerSlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'banner_id' => Banner::factory(),
            'type' => 'image',
            'path' => 'banners/'.fake()->uuid().'.jpg',
            'position' => 0,
        ];
    }

    public function video(): static
    {
        return $this->state(fn (): array => [
            'type' => 'video',
            'path' => 'banners/'.fake()->uuid().'.mp4',
        ]);
    }
}
