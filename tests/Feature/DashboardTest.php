<?php

it('can render the filament dashboard', function () {
    $this->asUser()->get('/')
        ->assertStatus(200);
});
