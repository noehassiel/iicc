<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each banner becomes one slide of the home hero with its own background,
     * so every former slide turns into a banner that keeps its parent's copy.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('media_type')->default('image')->after('button_url');
            $table->string('media_path')->nullable()->after('media_type');
            $table->string('poster_path')->nullable()->after('media_path');
            $table->boolean('is_active')->default(true)->after('poster_path');
            $table->unsignedInteger('position')->default(0)->after('is_active');
        });

        $position = 0;

        DB::table('banners')->orderBy('id')->get()->each(function (object $banner) use (&$position) {
            $slides = DB::table('banner_slides')->where('banner_id', $banner->id)->orderBy('position')->get();
            $copy = collect((array) $banner)->except(['id', 'created_at', 'updated_at'])->all();

            foreach ($slides as $index => $slide) {
                $media = [
                    'media_type' => $slide->type,
                    'media_path' => $slide->path,
                    'poster_path' => $slide->poster_path,
                    'position' => $position++,
                ];

                if ($index === 0) {
                    DB::table('banners')->where('id', $banner->id)->update($media);
                } else {
                    DB::table('banners')->insert([...$copy, ...$media, 'created_at' => now(), 'updated_at' => now()]);
                }
            }

            if ($slides->isEmpty()) {
                DB::table('banners')->where('id', $banner->id)->update(['position' => $position++]);
            }
        });

        Schema::dropIfExists('banner_slides');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'media_path', 'poster_path', 'is_active', 'position']);
        });
    }
};
