<?php

namespace Database\Factories;

use App\Enums\EventCategory;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(EventCategory::cases()),
            'slug' => fake()->unique()->slug(3),
            'title_es' => fake()->sentence(3),
            'title_zh' => '中華文化活動',
            'description_es' => fake()->paragraph(),
            'description_zh' => '歡迎大家一起參加我們的活動。',
            'date' => fake()->dateTimeBetween('-3 years'),
        ];
    }
}
