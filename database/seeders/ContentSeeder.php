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
                'title_zh' => '墨西哥中华文化学院',
                'subtitle_es' => '墨西哥中华文化学院',
                'subtitle_zh' => 'Instituto de Idioma y Cultura China en México',
                'button_label_es' => 'Comienza ahora',
                'button_label_zh' => '立即开始',
            ]);
        }

        if (! Review::query()->exists()) {
            $reviews = [
                ['author' => 'Robert201060', 'text_es' => 'Excelente institución, con una metodología y plan de aprendizaje excelentes. Igualmente, profesores que te dan un contexto muy adecuado sobre el idioma chino, la cultura y muchos aspectos útiles. También una administración muy cercana y atenta al desempeño personal.', 'text_zh' => '非常优秀的学院，教学方法和学习计划都很出色。老师们会针对中文、文化及许多实用面向提供非常恰当的背景说明。行政人员也非常亲切，并且关心每位学生的学习表现。'],
                ['author' => 'Hernández Martínez Miguel Angel', 'text_es' => 'Excelente instituto educativo para conocer y aprender sobre la cultura e idioma chino, principalmente chino simplificado, aunque en clase también se aprende sobre caracteres del chino tradicional. Cuenta con profesoras nativas amables, respetuosas y profesionales, y sus clases son divertidas y enriquecedoras.', 'text_zh' => '认识与学习中华文化和中文的优秀教育机构，主要教授简体中文，但课堂上也会学习繁体字。这里有亲切、尊重学生且专业的母语老师，课程既有趣又充实。'],
                ['author' => 'Victoria Castro', 'text_es' => 'Me encanta esta institución, tiene el mejor plan de estudios, su metodología de enseñanza es excelente. Es de las pocas escuelas que no solo te enseñan el idioma sino también su bella e interesante cultura, y tiene precios, horarios y modalidades muy accesibles. La mejor inversión.', 'text_zh' => '我非常喜欢这所学院，它有最好的课程规划，教学方法也非常出色。这是少数不只教语言，也教授其美丽又有趣的文化的学校，而且价格、上课时间和上课方式都很容易配合。最值得的投资。'],
                ['author' => 'F Ramón Braojos García', 'text_es' => 'Las maestras son muy buenas, tienen mucha paciencia y a mi hija le gusta mucho la clase. Es la única actividad extraescolar a la que nunca protesta por ir. Además de las clases de idioma están las clases culturales una vez al mes. Una buena escuela.', 'text_zh' => '老师们都很好，非常有耐心，我女儿很喜欢上课。这是她唯一从不抱怨要去的课外活动。除了语言课之外，每个月还有一次文化课。是一所好学校。'],
                ['author' => 'Andi Gonzalez', 'text_es' => 'Una de las pocas escuelas de mandarín en la Ciudad de México. Es una escuela relativamente pequeña con un programa completo de mandarín y un programa de inmersión en la cultura china. Bien organizada, con profesores muy capacitados.', 'text_zh' => '墨西哥城少数的华语学校之一。这是一所规模相对较小的学校，拥有完整的华语课程和中华文化沉浸课程。组织完善，老师们都训练有素。'],
                ['author' => 'H TC', 'text_es' => 'Mi hermana estudia chino en el instituto. Está muy feliz y le gustan mucho sus clases. Lo recomiendo.', 'text_zh' => '我妹妹在这所学院学中文。她非常开心，也很喜欢她的课。推荐！'],
                ['author' => 'CentralUsados MX', 'text_es' => 'Yo fui a pedir información, personalmente. Y es un lugar muy bonito. Decorado con dragones.', 'text_zh' => '我亲自去询问信息。这是个非常漂亮的地方，装饰着龙。'],
            ];

            foreach ($reviews as $review) {
                Review::create([...$review, 'rating' => 5]);
            }
        }

        $events = [
            [EventCategory::Cultural, '2026-01-01', 'Gastronomía', '美食'],
            [EventCategory::Cultural, '2026-01-01', 'Manualidad', '手作'],
            [EventCategory::Cultural, '2026-01-01', 'Otros', '其他'],
            [EventCategory::Campus, '2026-01-01', 'Año Nuevo Chino', '农历新年'],
            [EventCategory::Campus, '2026-01-01', 'Aniversarios del Instituto', '学院周年庆'],
            [EventCategory::Campus, '2026-01-01', 'Ceremonia de Apertura', '开学典礼'],
            [EventCategory::Huella, '2023-01-01', '4to Festival de Arte y Cultura de Taiwán', '第四届台湾艺术文化节'],
            [EventCategory::Huella, '2016-01-01', '3er Festival de Arte y Cultura de Taiwán', '第三届台湾艺术文化节'],
            [EventCategory::Huella, '2015-01-01', '2do Festival de Arte y Cultura de Taiwán', '第二届台湾艺术文化节'],
            [EventCategory::Huella, '2013-01-01', '1er Festival de Arte y Cultura de Taiwán', '第一届台湾艺术文化节'],
            [EventCategory::Huella, '2010-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道农历新年游行'],
            [EventCategory::Huella, '2009-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道农历新年游行'],
            [EventCategory::Huella, '2008-01-01', 'Desfile de Año Nuevo Chino sobre Reforma', '改革大道农历新年游行'],
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
