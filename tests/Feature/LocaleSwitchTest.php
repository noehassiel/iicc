<?php

test('visitors can switch the site to traditional chinese', function () {
    $this->get(route('locale.switch', 'zh_TW'))->assertRedirect(route('home'));

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('lang="zh-TW"', false)
        ->assertSee('關於我們');
});

test('spanish is the default language', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('lang="es"', false)
        ->assertSee('Nosotros');
});

test('unsupported locales are rejected', function () {
    $this->get(route('locale.switch', 'zh_CN'))->assertNotFound();
});
