<?php

use App\Models\Event;
use App\Models\EventPhoto;

test('public pages render', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with(['home', 'cursos', 'certificaciones', 'becas', 'otros-servicios', 'eventos.index', 'nosotros', 'contacto']);

test('events page embeds event details for the modal', function () {
    Event::factory()->create(['slug' => 'ano-nuevo-chino']);

    $this->get(route('eventos.index'))
        ->assertOk()
        ->assertSee('ano-nuevo-chino')
        ->assertSee('data-cylindrical-carousel', false);
});

test('events page gives each gallery photo its caption in the current language', function () {
    $event = Event::factory()->create(['title_es' => 'Año Nuevo Chino']);
    EventPhoto::factory()->for($event)->create(['caption_es' => 'Danza del león', 'caption_zh' => '舞獅表演']);
    EventPhoto::factory()->for($event)->create(['caption_es' => null, 'caption_zh' => null]);

    $this->get(route('eventos.index'))
        ->assertOk()
        ->assertSee('caption\u0022:\u0022Danza del león', false)
        ->assertSee('caption\u0022:\u0022Año Nuevo Chino', false);

    $this->withSession(['locale' => 'zh_TW'])
        ->get(route('eventos.index'))
        ->assertSee('caption\u0022:\u0022舞獅表演', false);
});
