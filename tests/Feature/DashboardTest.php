<?php

test('the old dashboard url points to the admin panel', function () {
    $this->get(route('dashboard'))->assertRedirect('/admin');
});
