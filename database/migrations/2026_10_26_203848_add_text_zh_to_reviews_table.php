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
            'Robert201060' => '非常优秀的学院，教学方法和学习计划都很出色。老师们会针对中文、文化及许多实用面向提供非常恰当的背景说明。行政人员也非常亲切，并且关心每位学生的学习表现。',
            'Hernández Martínez Miguel Angel' => '认识与学习中华文化和中文的优秀教育机构，主要教授简体中文，但课堂上也会学习繁体字。这里有亲切、尊重学生且专业的母语老师，课程既有趣又充实。',
            'Victoria Castro' => '我非常喜欢这所学院，它有最好的课程规划，教学方法也非常出色。这是少数不只教语言，也教授其美丽又有趣的文化的学校，而且价格、上课时间和上课方式都很容易配合。最值得的投资。',
            'F Ramón Braojos García' => '老师们都很好，非常有耐心，我女儿很喜欢上课。这是她唯一从不抱怨要去的课外活动。除了语言课之外，每个月还有一次文化课。是一所好学校。',
            'Andi Gonzalez' => '墨西哥城少数的华语学校之一。这是一所规模相对较小的学校，拥有完整的华语课程和中华文化沉浸课程。组织完善，老师们都训练有素。',
            'H TC' => '我妹妹在这所学院学中文。她非常开心，也很喜欢她的课。推荐！',
            'CentralUsados MX' => '我亲自去询问信息。这是个非常漂亮的地方，装饰着龙。',
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
