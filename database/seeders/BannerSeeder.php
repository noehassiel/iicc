<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    /**
     * Seed the two home hero slides with the client's banner photos. Safe to run again.
     */
    public function run(): void
    {
        $banners = [
            [
                'image' => 'Banner_Inicio_1.jpg',
                'title_es' => 'Divertido',
                'title_zh' => '很有趣',
                'subtitle_es' => 'Aprender chino es',
                'subtitle_zh' => '學中文',
            ],
            [
                'image' => 'Banner_Inicio_2.jpg',
                'title_es' => 'Instituto de Idioma y Cultura China en México',
                'title_zh' => '墨西哥中華文化學院',
                'subtitle_es' => '墨西哥中華文化學院',
                'subtitle_zh' => 'Instituto de Idioma y Cultura China en México',
            ],
        ];

        foreach ($banners as $position => $banner) {
            $mediaPath = 'banners/'.$banner['image'];

            if (! Storage::disk('public')->exists($mediaPath)) {
                Storage::disk('public')->put($mediaPath, file_get_contents(public_path('img/Inicio/'.$banner['image'])));
            }

            Banner::updateOrCreate(['media_path' => $mediaPath], [
                'title_es' => $banner['title_es'],
                'title_zh' => $banner['title_zh'],
                'subtitle_es' => $banner['subtitle_es'],
                'subtitle_zh' => $banner['subtitle_zh'],
                'button_label_es' => 'Comienza ahora',
                'button_label_zh' => '立即開始',
                'button_url' => null,
                'media_type' => 'image',
                'is_active' => true,
                'position' => $position,
            ]);
        }
    }
}
