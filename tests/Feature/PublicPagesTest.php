<?php

use App\Models\Event;

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
