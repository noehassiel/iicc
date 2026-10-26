<?php

namespace Database\Seeders;

use App\Enums\EventCategory;
use App\Models\Banner;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Seed the banner and the events from the client's copy. Safe to run again.
     */
    public function run(): void
    {
        if (! Banner::query()->exists()) {
            Banner::create([
                'title_es' => 'Instituto de Idioma y Cultura China en México',
                'title_zh' => '墨西哥中華文化學院',
                'subtitle_es' => '墨西哥中華文化學院',
                'subtitle_zh' => 'Instituto de Idioma y Cultura China en México',
                'button_label_es' => 'Comienza ahora',
                'button_label_zh' => '立即開始',
            ]);
        }

        if (! Review::query()->exists()) {
            $reviews = [
                ['author' => 'Robert201060', 'text' => 'Excelente institución, con una metodología y plan de aprendizaje excelentes. Igualmente, profesores que te dan un contexto muy adecuado sobre el idioma chino, la cultura y muchos aspectos útiles. También una administración muy cercana y atenta al desempeño personal.'],
                ['author' => 'Hernández Martínez Miguel Angel', 'text' => 'Excelente instituto educativo para conocer y aprender sobre la cultura e idioma chino, principalmente chino simplificado, aunque en clase también se aprende sobre caracteres del chino tradicional. Cuenta con profesoras nativas amables, respetuosas y profesionales, y sus clases son divertidas y enriquecedoras.'],
                ['author' => 'Victoria Castro', 'text' => 'Me encanta esta institución, tiene el mejor plan de estudios, su metodología de enseñanza es excelente. Es de las pocas escuelas que no solo te enseñan el idioma sino también su bella e interesante cultura, y tiene precios, horarios y modalidades muy accesibles. La mejor inversión.'],
                ['author' => 'F Ramón Braojos García', 'text' => 'Las maestras son muy buenas, tienen mucha paciencia y a mi hija le gusta mucho la clase. Es la única actividad extraescolar a la que nunca protesta por ir. Además de las clases de idioma están las clases culturales una vez al mes. Una buena escuela.'],
                ['author' => 'Andi Gonzalez', 'text' => 'Una de las pocas escuelas de mandarín en la Ciudad de México. Es una escuela relativamente pequeña con un programa completo de mandarín y un programa de inmersión en la cultura china. Bien organizada, con profesores muy capacitados.'],
                ['author' => 'H TC', 'text' => 'Mi hermana estudia chino en el instituto. Está muy feliz y le gustan mucho sus clases. Lo recomiendo.'],
                ['author' => 'CentralUsados MX', 'text' => 'Yo fui a pedir información, personalmente. Y es un lugar muy bonito. Decorado con dragones.'],
            ];

            foreach ($reviews as $review) {
                Review::create([...$review, 'rating' => 5]);
            }
        }

        $events = [
            [EventCategory::Cultural, '2026-01-01', 'Gastronomía', '美食'],
            [EventCategory::Cultural, '2026-01-01', 'Manualidad', '手作'],
            [EventCategory::Cultural, '2026-01-01', 'Otros', '其他'],
            [EventCategory::Campus, '2026-01-01', 'Año Nuevo Chino', '農曆新年'],
            [EventCategory::Campus, '2026-01-01', 'Aniversarios del Instituto', '學院週年慶'],
            [EventCategory::Campus, '2026-01-01', 'Ceremonia de Apertura', '開學典禮'],
            [EventCategory::Huella, '2023-01-01', '4to Festival de Arte y Cultura de Taiwán', '第四屆臺灣藝術文化節'],
            [EventCategory::Huella, '2016-01-01', '3er Festival de Arte y Cultura de Taiwán', '第三屆臺灣藝術文化節'],
            [EventCategory::Huella, '2015-01-01', '2do Festival de Arte y Cultura de Taiwán', '第二屆臺灣藝術文化節'],
            [EventCategory::Huella, '2013-01-01', '1er Festival de Arte y Cultura de Taiwán', '第一屆臺灣藝術文化節'],
            [EventCategory::Huella, '2010-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道農曆新年遊行'],
            [EventCategory::Huella, '2009-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道農曆新年遊行'],
            [EventCategory::Huella, '2008-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道農曆新年遊行'],
        ];

        foreach ($events as [$category, $date, $titleEs, $titleZh]) {
            $slug = Str::slug($titleEs).($category === EventCategory::Huella ? '-'.substr($date, 0, 4) : '');

            Event::query()->firstOrCreate(['slug' => $slug], [
                'category' => $category,
                'date' => $date,
                'title_es' => $titleEs,
                'title_zh' => $titleZh,
            ]);
        }
    }
}
