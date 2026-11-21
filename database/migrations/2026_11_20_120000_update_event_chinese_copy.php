<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Applies the client's Chinese copy for the events page (titles and descriptions).
 * Events are otherwise edited from the admin panel; this only touches the zh columns.
 */
return new class extends Migration
{
    /**
     * @var array<string, array{0: string, 1: string}> slug => [title_zh, description_zh]
     */
    private const COPY = [
        'gastronomia' => ['美食工作坊', '在活動中，你將親手製作傳統佳餚，並在輕鬆的氛圍中自然練習中文與認識背後的節慶文化。'],
        'manualidad' => ['手作工作坊', '帶您親身體驗書法、剪紙與其他傳統手工藝，用雙手體驗傳承千年的藝術美學。'],
        'otros' => ['其他特色文化體驗', '透過茶藝、象棋、圍棋與各式節慶體驗，讓您自然沉浸於豐富的中華文化世界。'],
        'ano-nuevo-chino' => ['春節慶典活動', '每年的農曆春節，正是本校年度最大盛典。我們以傳統舞蹈、美食與各項春節活動，與大眾一同慶祝農曆新年的到來，並祝賀新的一年風調雨順、平安大吉。'],
        'aniversarios-del-instituto' => ['學校校慶', '每年五月，是 IICC 的校慶兼母親節慶祝活動。師生與家長們齊聚一堂，透過精彩的才藝表演，共同感恩母親的辛勞，並見證學校又一年的成長與喜悅。'],
        'ceremonia-de-apertura' => ['開學典禮', '每年九月，再次迎來 IICC 又一個新學年。我們熱烈歡迎新生的加入，也誠摯恭喜所有努力學習、付出的獎學金生們，讓我們一同展開嶄新的中文學習之旅。'],
        '4to-festival-de-arte-y-cultura-de-taiwan-2023' => ['第四屆臺灣文化日', '歷經疫情後的盛大回歸，IICC 不只帶來豐富文化體驗活動，更攜手各界夥伴，透過來自臺灣的科技精品、各式美食佳餚，和墨西哥人分享更加道地的臺灣文化與傳統。'],
        '3er-festival-de-arte-y-cultura-de-taiwan-2016' => ['第三屆臺灣文化日', '台灣文化週已逐漸成為在地民眾引頸期盼的年度盛事。IICC 透過多元的傳統體驗，進一步深化了墨西哥與臺灣之間的真摯友誼。'],
        '2do-festival-de-arte-y-cultura-de-taiwan-2015' => ['第二屆臺灣文化日', '延續首屆的感動，我們進一步擴大了文化交流的規模。透過更豐富的藝術展演與互動體驗，讓臺灣的文化魅力在墨西哥持續發酵。'],
        '1er-festival-de-arte-y-cultura-de-taiwan-2013' => ['第一屆臺灣文化日', '2013 年，IICC 首次將臺灣的文化藝術帶進墨西哥市中心，透過傳統表演、茶道花藝、民俗童玩、書法與各式傳統美食等，為這場跨國界的友誼盛會拉開序幕。'],
        'desfile-de-ano-nuevo-chino-sobre-reforma-2010' => ['春節遊行活動', '2010 年的農曆春節，IICC 同樣受邀走上改革大道，一起歡慶虎年的到來。'],
        'desfile-de-ano-nuevo-chino-sobre-reforma-2009' => ['春節遊行活動', 'IICC 再次受邀參與春節遊行活動，我們穿著更為華麗的傳統服飾共襄盛舉，與海外華人僑胞及墨西哥市民共度美好的農曆春節。'],
        'desfile-de-ano-nuevo-chino-sobre-reforma-2008' => ['春節遊行活動', '這年，IICC 的師生們身著傳統服飾，一同參與一年一度的春節遊行活動，歡慶新年的到來。'],
    ];

    public function up(): void
    {
        foreach (self::COPY as $slug => [$title, $description]) {
            DB::table('events')->where('slug', $slug)->update([
                'title_zh' => $title,
                'description_zh' => $description,
            ]);
        }
    }

    public function down(): void
    {
        // Copy change only; nothing to restore structurally.
    }
};
