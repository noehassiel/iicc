<?php

namespace Database\Seeders;

use App\Enums\EventCategory;
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
        $this->call(BannerSeeder::class);

        if (! Review::query()->exists()) {
            $reviews = [
                ['author' => 'Robert201060', 'text_es' => 'Excelente institución, con una metodología y plan de aprendizaje excelentes. Igualmente, profesores que te dan un contexto muy adecuado sobre el idioma chino, la cultura y muchos aspectos útiles. También una administración muy cercana y atenta al desempeño personal.', 'text_zh' => '非常優秀的學院，教學方法和學習計畫都很出色。老師們會針對中文、文化及許多實用面向提供非常恰當的背景說明。行政人員也非常親切，並且關心每位學生的學習表現。'],
                ['author' => 'Hernández Martínez Miguel Angel', 'text_es' => 'Excelente instituto educativo para conocer y aprender sobre la cultura e idioma chino, principalmente chino simplificado, aunque en clase también se aprende sobre caracteres del chino tradicional. Cuenta con profesoras nativas amables, respetuosas y profesionales, y sus clases son divertidas y enriquecedoras.', 'text_zh' => '這是一所學習中文與中華文化的優質學校。課程以簡體字為主，但在課堂中也能學到繁體字。老師們皆為中文母語者，不僅待人親切、對教學充滿熱忱且具備極高的專業素養，讓每堂課都充滿樂趣且收穫滿滿！'],
                ['author' => 'Victoria Castro', 'text_es' => 'Me encanta esta institución, tiene el mejor plan de estudios, su metodología de enseñanza es excelente. Es de las pocas escuelas que no solo te enseñan el idioma sino también su bella e interesante cultura, y tiene precios, horarios y modalidades muy accesibles. La mejor inversión.', 'text_zh' => '我非常喜歡這所學校！這裡有最棒的課程規劃，教學方式也相當出色。這裡是少數不只教你中文的學校，他們還會帶你深度認識這個語言背後優美且有趣的文化。另外，這裡不僅學費實惠，上課時間及授課方式也相當彈性，這絕對是最好的自我投資！'],
                ['author' => 'F Ramón Braojos García', 'text_es' => 'Las maestras son muy buenas, tienen mucha paciencia y a mi hija le gusta mucho la clase. Es la única actividad extraescolar a la que nunca protesta por ir. Además de las clases de idioma están las clases culturales una vez al mes. Una buena escuela.', 'text_zh' => '這裡的老師都非常優秀，對學生極具耐心，我女兒相當喜歡來這裡上課。這是她唯一一個從不排斥參加的課外活動！除了語言課程，每個月還會舉辦一次文化課。這真的是一所很棒的學校。'],
                ['author' => 'Andi Gonzalez', 'text_es' => 'Una de las pocas escuelas de mandarín en la Ciudad de México. Es una escuela relativamente pequeña con un programa completo de mandarín y un programa de inmersión en la cultura china. Bien organizada, con profesores muy capacitados.', 'text_zh' => '墨西哥城少數的華語學校之一。這是一所規模相對較小的學校，擁有完整的華語課程和中華文化沉浸課程。組織完善，老師們都訓練有素。'],
                ['author' => 'H TC', 'text_es' => 'Mi hermana estudia chino en el instituto. Está muy feliz y le gustan mucho sus clases. Lo recomiendo.', 'text_zh' => '我妹妹很開心在這間學校學習中文。而且她超級喜歡這裡的課程。我真心推薦這所學校給大家！'],
                ['author' => 'CentralUsados MX', 'text_es' => 'Yo fui a pedir información, personalmente. Y es un lugar muy bonito. Decorado con dragones.', 'text_zh' => '我有親自去那邊諮詢過。那裡非常漂亮，還有著許多龍的裝飾。'],
            ];

            foreach ($reviews as $review) {
                Review::create([...$review, 'rating' => 5]);
            }
        }

        $events = [
            [EventCategory::Cultural, '2026-01-01', 'Gastronomía', '美食工作坊'],
            [EventCategory::Cultural, '2026-01-01', 'Manualidad', '手作工作坊'],
            [EventCategory::Cultural, '2026-01-01', 'Otros', '其他特色文化體驗'],
            [EventCategory::Campus, '2026-01-01', 'Año Nuevo Chino', '春節慶典活動'],
            [EventCategory::Campus, '2026-01-01', 'Aniversarios del Instituto', '學校校慶'],
            [EventCategory::Campus, '2026-01-01', 'Ceremonia de Apertura', '開學典禮'],
            [EventCategory::Huella, '2023-01-01', '4to Festival de Arte y Cultura de Taiwán', '第四屆臺灣文化日'],
            [EventCategory::Huella, '2016-01-01', '3er Festival de Arte y Cultura de Taiwán', '第三屆臺灣文化日'],
            [EventCategory::Huella, '2015-01-01', '2do Festival de Arte y Cultura de Taiwán', '第二屆臺灣文化日'],
            [EventCategory::Huella, '2013-01-01', '1er Festival de Arte y Cultura de Taiwán', '第一屆臺灣文化日'],
            [EventCategory::Huella, '2010-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '春節遊行活動'],
            [EventCategory::Huella, '2009-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '春節遊行活動'],
            [EventCategory::Huella, '2008-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '春節遊行活動'],
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

        $this->call(EventPhotoSeeder::class);
    }
}
