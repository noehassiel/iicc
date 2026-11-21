<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banner_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('image');
            $table->string('path');
            $table->string('poster_path')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        DB::table('banners')->whereNotNull('image_path')->get()->each(fn (object $banner) => DB::table('banner_slides')->insert([
            'banner_id' => $banner->id,
            'type' => 'image',
            'path' => $banner->image_path,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('image_path')->nullable();
        });

        Schema::dropIfExists('banner_slides');
    }
};
