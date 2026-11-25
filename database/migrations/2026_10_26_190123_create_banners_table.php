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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_zh')->nullable();
            $table->string('subtitle_es')->nullable();
            $table->string('subtitle_zh')->nullable();
            $table->string('button_label_es')->nullable();
            $table->string('button_label_zh')->nullable();
            $table->string('button_url')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
