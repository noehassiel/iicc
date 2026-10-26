<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Make reviews bilingual and translate the ones loaded from the client's copy.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('text', 'text_es');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->text('text_zh')->nullable()->after('text_es');
        });

        $translations = [
            'Robert201060' => '非常優秀的學院，教學方法和學習計畫都很出色。老師們會針對中文、文化及許多實用面向提供非常恰當的背景說明。行政人員也非常親切，並且關心每位學生的學習表現。',
            'Hernández Martínez Miguel Angel' => '認識與學習中華文化和中文的優秀教育機構，主要教授簡體中文，但課堂上也會學習繁體字。這裡有親切、尊重學生且專業的母語老師，課程既有趣又充實。',
            'Victoria Castro' => '我非常喜歡這所學院，它有最好的課程規劃，教學方法也非常出色。這是少數不只教語言，也教授其美麗又有趣的文化的學校，而且價格、上課時間和上課方式都很容易配合。最值得的投資。',
            'F Ramón Braojos García' => '老師們都很好，非常有耐心，我女兒很喜歡上課。這是她唯一從不抱怨要去的課外活動。除了語言課之外，每個月還有一次文化課。是一所好學校。',
            'Andi Gonzalez' => '墨西哥城少數的華語學校之一。這是一所規模相對較小的學校，擁有完整的華語課程和中華文化沉浸課程。組織完善，老師們都訓練有素。',
            'H TC' => '我妹妹在這所學院學中文。她非常開心，也很喜歡她的課。推薦！',
            'CentralUsados MX' => '我親自去詢問資訊。這是個非常漂亮的地方，裝飾著龍。',
        ];

        foreach ($translations as $author => $text) {
            DB::table('reviews')->where('author', $author)->whereNull('text_zh')->update(['text_zh' => $text]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('text_zh');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('text_es', 'text');
        });
    }
};
