<?php

use App\Enums\EventCategory;
use App\Livewire\Admin\Events\Form;
use App\Livewire\Admin\Events\Index;
use App\Models\Event;
use App\Models\EventPhoto;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->admin()->create());
});

test('admins can create an event with cover and gallery', function () {
    Livewire::test(Form::class)
        ->set('category', 'campus')
        ->set('title_es', 'Año Nuevo Chino')
        ->set('title_zh', '農曆新年')
        ->set('date', '2026-02-17')
        ->set('cover', UploadedFile::fake()->image('portada.jpg'))
        ->set('photos', [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')])
        ->call('save')
        ->assertHasNoErrors();

    $event = Event::firstWhere('slug', 'ano-nuevo-chino');

    expect($event->category)->toBe(EventCategory::Campus)
        ->and($event->photos)->toHaveCount(2);
    Storage::disk('public')->assertExists($event->cover_path);
});

test('events with empty optional fields can be edited', function () {
    $event = Event::factory()->create(['title_zh' => null, 'description_es' => null, 'description_zh' => null]);

    $this->get(route('admin.events.edit', $event))->assertOk();
});

test('slugs must be unique', function () {
    Event::factory()->create(['slug' => 'ano-nuevo-chino']);

    Livewire::test(Form::class)
        ->set('title_es', 'Año Nuevo Chino')
        ->set('date', '2026-02-17')
        ->call('save')
        ->assertHasErrors(['slug' => 'unique']);
});

test('gallery photos can be reordered', function () {
    $event = Event::factory()->create();
    $first = EventPhoto::factory()->for($event)->create(['position' => 0]);
    $second = EventPhoto::factory()->for($event)->create(['position' => 1]);

    Livewire::test(Form::class, ['event' => $event])->call('movePhoto', $second->id, -1);

    expect($event->photos()->pluck('id')->all())->toBe([$second->id, $first->id]);
});

test('photos from another event cannot be deleted', function () {
    $event = Event::factory()->create();
    $foreign = EventPhoto::factory()->create();

    Livewire::test(Form::class, ['event' => $event])
        ->call('deletePhoto', $foreign->id)
        ->assertNotFound();

    expect($foreign->fresh())->not->toBeNull();
});

test('deleting an event removes its files', function () {
    $event = Event::factory()->create(['cover_path' => 'events/portada.jpg']);
    Storage::disk('public')->put('events/portada.jpg', 'x');

    Livewire::test(Index::class)->call('delete', $event->id);

    expect(Event::count())->toBe(0);
    Storage::disk('public')->assertMissing('events/portada.jpg');
});

test('the events page lists events by section', function () {
    Event::factory()->create(['category' => EventCategory::Cultural, 'title_es' => 'Taller de caligrafía']);

    $this->get(route('eventos.index'))->assertOk()->assertSee('Taller de caligrafía');
});
