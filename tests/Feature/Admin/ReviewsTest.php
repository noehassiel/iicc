<?php

use App\Livewire\Admin\Reviews\Form;
use App\Livewire\Admin\Reviews\Index;
use App\Models\Review;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

test('admins can open the review screens', function () {
    $review = Review::factory()->create();

    $this->get(route('admin.reviews.index'))->assertOk()->assertSee($review->author);
    $this->get(route('admin.reviews.edit', $review))->assertOk();
});

test('admins can add a review', function () {
    Livewire::test(Form::class)
        ->set('author', 'Robert201060')
        ->set('rating', 5)
        ->set('text', 'Excelente institución.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.reviews.index'));

    expect(Review::firstWhere('author', 'Robert201060')->is_published)->toBeTrue();
});

test('ratings must be between one and five', function () {
    Livewire::test(Form::class)
        ->set('author', 'Alguien')
        ->set('text', 'Texto')
        ->set('rating', 6)
        ->call('save')
        ->assertHasErrors(['rating' => 'between']);
});

test('admins can hide a review', function () {
    $review = Review::factory()->create();

    Livewire::test(Index::class)->call('togglePublished', $review->id);

    expect($review->fresh()->is_published)->toBeFalse();
});

test('the home page shows at most four published reviews of four stars or more', function () {
    Review::factory()->count(5)->create();
    $hidden = Review::factory()->hidden()->create(['author' => 'Reseña oculta']);
    $low = Review::factory()->create(['author' => 'Tres estrellas', 'rating' => 3]);

    $featured = Review::featured();

    expect($featured)->toHaveCount(4)
        ->and($featured->pluck('id'))->not->toContain($hidden->id, $low->id);

    $this->get(route('home'))->assertOk()->assertDontSee('Reseña oculta')->assertDontSee('Tres estrellas');
});
