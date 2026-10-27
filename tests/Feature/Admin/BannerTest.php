<?php

use App\Livewire\Admin\Banners\Form;
use App\Livewire\Admin\Banners\Index;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->admin()->create());
});

test('admins can create several banners', function () {
    Livewire::test(Form::class)
        ->set('title_es', 'Aprende chino')
        ->set('title_zh', '學華語')
        ->set('media', UploadedFile::fake()->image('fondo.jpg'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.banners.index'));

    Livewire::test(Form::class)
        ->set('title_es', 'Certificaciones')
        ->set('media', UploadedFile::fake()->create('clip.mp4', 1024, 'video/mp4'))
        ->set('poster', UploadedFile::fake()->image('poster.jpg'))
        ->call('save')
        ->assertHasNoErrors();

    [$image, $video] = Banner::active();

    expect($image->title_es)->toBe('Aprende chino')
        ->and($image->media_type)->toBe('image')
        ->and($video->media_type)->toBe('video')
        ->and($video->position)->toBeGreaterThan($image->position);
    Storage::disk('public')->assertExists([$image->media_path, $video->media_path, $video->poster_path]);
});

test('a new banner needs an image or video background', function () {
    Livewire::test(Form::class)
        ->set('title_es', 'Aprende chino')
        ->call('save')
        ->assertHasErrors(['media' => 'required']);

    Livewire::test(Form::class)
        ->set('title_es', 'Aprende chino')
        ->set('media', UploadedFile::fake()->create('notas.pdf', 10, 'application/pdf'))
        ->call('save')
        ->assertHasErrors(['media' => 'mimes']);
});

test('a banner can be edited without uploading its background again', function () {
    $banner = Banner::factory()->create(['subtitle_zh' => null, 'button_url' => null]);

    $this->get(route('admin.banners.edit', $banner))->assertOk();

    Livewire::test(Form::class, ['banner' => $banner])
        ->set('title_es', 'Nuevo título')
        ->call('save')
        ->assertHasNoErrors();

    expect($banner->fresh()->title_es)->toBe('Nuevo título');
});

test('the spanish title is required', function () {
    Livewire::test(Form::class)
        ->set('title_es', '')
        ->call('save')
        ->assertHasErrors(['title_es' => 'required']);
});

test('admins can hide, reorder and delete banners', function () {
    [$first, $second] = Banner::factory()->count(2)->sequence(['position' => 0], ['position' => 1])->create();
    Storage::disk('public')->put($first->media_path, 'image');

    Livewire::test(Index::class)
        ->call('toggleActive', $second->id)
        ->call('move', $second->id, -1)
        ->call('delete', $first->id);

    expect(Banner::query()->pluck('id')->all())->toBe([$second->id])
        ->and($second->fresh()->is_active)->toBeFalse();
    Storage::disk('public')->assertMissing($first->media_path);
});

test('the home hero shows every active banner in order and in the visitor language', function () {
    Banner::factory()->video()->create(['title_es' => 'Aprende chino', 'title_zh' => '學華語', 'media_path' => 'banners/clip.mp4', 'position' => 0]);
    Banner::factory()->create(['title_es' => 'Certificaciones', 'media_path' => 'banners/fondo.jpg', 'position' => 1]);
    Banner::factory()->inactive()->create(['title_es' => 'Banner oculto']);

    $this->get(route('home'))
        ->assertSeeInOrder(['banners/clip.mp4', 'banners/fondo.jpg', 'Aprende chino', 'Certificaciones'])
        ->assertDontSee('Banner oculto');

    $this->withSession(['locale' => 'zh_TW'])->get(route('home'))->assertSee('學華語');
});
