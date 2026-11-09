<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EventPhotoSeeder extends Seeder
{
    /**
     * Attach the client's photos in public/img/Eventos to their events. Safe to run again.
     *
     * The photo list (and each photo's caption in both languages) lives in data/event-photos.json,
     * keyed by event slug. The first photo becomes the event cover when it has none.
     */
    public function run(): void
    {
        /** @var array<string, list<array{file: string, caption_es: string, caption_zh: string}>> $photosByEvent */
        $photosByEvent = json_decode(file_get_contents(__DIR__.'/data/event-photos.json'), true);

        foreach ($photosByEvent as $slug => $photos) {
            $event = Event::query()->where('slug', $slug)->first();

            if ($event === null || $photos === []) {
                continue;
            }

            foreach ($photos as $position => $photo) {
                $path = "events/{$event->id}/{$photo['file']}";

                if (! Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, file_get_contents(public_path("img/Eventos/{$slug}/{$photo['file']}")));
                }

                $event->photos()->updateOrCreate(['path' => $path], [
                    'caption_es' => $photo['caption_es'],
                    'caption_zh' => $photo['caption_zh'],
                    'position' => $position,
                ]);
            }

            if ($event->cover_path === null) {
                $event->update(['cover_path' => "events/{$event->id}/{$photos[0]['file']}"]);
            }
        }
    }
}
