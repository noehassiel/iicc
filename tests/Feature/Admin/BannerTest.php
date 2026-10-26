<?php

use App\Livewire\Admin\Banner\Edit;
use App\Models\Banner;
use App\Models\BannerSlide;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->admin()->create());
});

test('admins can save the banner with image and video backgrounds', function () {
    Livewire::test(Edit::class)
        ->set('title_es', 'Aprende chino')
        ->set('title_zh', '學華語')
        ->set('media', [
            UploadedFile::fake()->image('fondo.jpg'),
            UploadedFile::fake()->create('clip.mp4', 1024, 'video/mp4'),
        ])
        ->call('save')
        ->assertHasNoErrors();

    $banner = Banner::current();

    expect($banner->title_es)->toBe('Aprende chino')
        ->and($banner->slides->pluck('type')->all())->toBe(['image', 'video']);
    $banner->slides->each(fn (BannerSlide $slide) => Storage::disk('public')->assertExists($slide->path));
});

test('backgrounds must be images or videos', function () {
    Livewire::test(Edit::class)
        ->set('title_es', 'Aprende chino')
        ->set('media', [UploadedFile::fake()->create('notas.pdf', 10, 'application/pdf')])
        ->call('save')
        ->assertHasErrors(['media.0' => 'mimes']);
});

test('admins can add a poster to a video background', function () {
    $slide = BannerSlide::factory()->video()->create();

    Livewire::test(Edit::class)
        ->set("posters.{$slide->id}", UploadedFile::fake()->image('poster.jpg'))
        ->assertHasNoErrors();

    Storage::disk('public')->assertExists($slide->fresh()->poster_path);
});

test('admins can reorder and delete backgrounds', function () {
    $banner = Banner::factory()->create();
    [$first, $second] = BannerSlide::factory()->for($banner)->count(2)->sequence(['position' => 0], ['position' => 1])->create();
    Storage::disk('public')->put($first->path, 'image');

    Livewire::test(Edit::class)
        ->call('moveSlide', $second->id, -1)
        ->call('deleteSlide', $first->id);

    expect($banner->slides()->pluck('id')->all())->toBe([$second->id]);
    Storage::disk('public')->assertMissing($first->path);
});

test('backgrounds of another banner cannot be touched', function () {
    Banner::factory()->create();
    $foreign = BannerSlide::factory()->create();
    Banner::factory()->create();

    Livewire::test(Edit::class)
        ->call('deleteSlide', $foreign->id)
        ->assertNotFound();

    expect($foreign->fresh())->not->toBeNull();
});

test('a banner with empty optional fields can be edited', function () {
    Banner::factory()->create(['subtitle_zh' => null, 'button_url' => null]);

    $this->get(route('admin.banner.edit'))->assertOk();
});

test('the spanish title is required', function () {
    Livewire::test(Edit::class)
        ->set('title_es', '')
        ->call('save')
        ->assertHasErrors(['title_es' => 'required']);
});

test('the home page shows the banner in the visitor language', function () {
    Banner::factory()->create(['title_es' => 'Aprende chino', 'title_zh' => '學華語']);

    $this->get(route('home'))->assertSee('Aprende chino');

    $this->withSession(['locale' => 'zh_TW'])->get(route('home'))->assertSee('學華語');
});

test('the home hero shows every background in order', function () {
    $banner = Banner::factory()->create();
    BannerSlide::factory()->for($banner)->video()->create(['path' => 'banners/clip.mp4', 'position' => 0]);
    BannerSlide::factory()->for($banner)->create(['path' => 'banners/fondo.jpg', 'position' => 1]);

    $this->get(route('home'))->assertSeeInOrder(['banners/clip.mp4', 'banners/fondo.jpg']);
});
