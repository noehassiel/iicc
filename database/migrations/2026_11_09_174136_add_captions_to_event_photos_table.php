<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_photos', function (Blueprint $table) {
            $table->string('caption_es')->nullable()->after('path');
            $table->string('caption_zh')->nullable()->after('caption_es');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_photos', function (Blueprint $table) {
            $table->dropColumn(['caption_es', 'caption_zh']);
        });
    }
};
