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
                ['author' => 'Robert201060', 'text_es' => 'Excelente institución, con una metodología y plan de aprendizaje excelentes. Igualmente, profesores que te dan un contexto muy adecuado sobre el idioma chino, la cultura y muchos aspectos útiles. También una administración muy cercana y atenta al desempeño personal.', 'text_zh' => '非常優秀的學院，教學方法和學習計畫都很出色。老師們會針對中文、文化及許多實用面向提供非常恰當的背景說明。行政人員也非常親切，並且關心每位學生的學習表現。'],
                ['author' => 'Hernández Martínez Miguel Angel', 'text_es' => 'Excelente instituto educativo para conocer y aprender sobre la cultura e idioma chino, principalmente chino simplificado, aunque en clase también se aprende sobre caracteres del chino tradicional. Cuenta con profesoras nativas amables, respetuosas y profesionales, y sus clases son divertidas y enriquecedoras.', 'text_zh' => '認識與學習中華文化和中文的優秀教育機構，主要教授簡體中文，但課堂上也會學習繁體字。這裡有親切、尊重學生且專業的母語老師，課程既有趣又充實。'],
                ['author' => 'Victoria Castro', 'text_es' => 'Me encanta esta institución, tiene el mejor plan de estudios, su metodología de enseñanza es excelente. Es de las pocas escuelas que no solo te enseñan el idioma sino también su bella e interesante cultura, y tiene precios, horarios y modalidades muy accesibles. La mejor inversión.', 'text_zh' => '我非常喜歡這所學院，它有最好的課程規劃，教學方法也非常出色。這是少數不只教語言，也教授其美麗又有趣的文化的學校，而且價格、上課時間和上課方式都很容易配合。最值得的投資。'],
                ['author' => 'F Ramón Braojos García', 'text_es' => 'Las maestras son muy buenas, tienen mucha paciencia y a mi hija le gusta mucho la clase. Es la única actividad extraescolar a la que nunca protesta por ir. Además de las clases de idioma están las clases culturales una vez al mes. Una buena escuela.', 'text_zh' => '老師們都很好，非常有耐心，我女兒很喜歡上課。這是她唯一從不抱怨要去的課外活動。除了語言課之外，每個月還有一次文化課。是一所好學校。'],
                ['author' => 'Andi Gonzalez', 'text_es' => 'Una de las pocas escuelas de mandarín en la Ciudad de México. Es una escuela relativamente pequeña con un programa completo de mandarín y un programa de inmersión en la cultura china. Bien organizada, con profesores muy capacitados.', 'text_zh' => '墨西哥城少數的華語學校之一。這是一所規模相對較小的學校，擁有完整的華語課程和中華文化沉浸課程。組織完善，老師們都訓練有素。'],
                ['author' => 'H TC', 'text_es' => 'Mi hermana estudia chino en el instituto. Está muy feliz y le gustan mucho sus clases. Lo recomiendo.', 'text_zh' => '我妹妹在這所學院學中文。她非常開心，也很喜歡她的課。推薦！'],
                ['author' => 'CentralUsados MX', 'text_es' => 'Yo fui a pedir información, personalmente. Y es un lugar muy bonito. Decorado con dragones.', 'text_zh' => '我親自去詢問資訊。這是個非常漂亮的地方，裝飾著龍。'],
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
