<?php

use App\Livewire\Admin\Banner\Edit;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->admin()->create());
});

test('admins can save the banner with an image', function () {
    Livewire::test(Edit::class)
        ->set('title_es', 'Aprende chino')
        ->set('title_zh', '學華語')
        ->set('image', UploadedFile::fake()->image('fondo.jpg'))
        ->call('save')
        ->assertHasNoErrors();

    $banner = Banner::current();

    expect($banner->title_es)->toBe('Aprende chino');
    Storage::disk('public')->assertExists($banner->image_path);
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
