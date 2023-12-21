<?php

it("doesn't allow unauthenticated users access to the panel", function () {
    $this->get('/')
        ->assertStatus(302)
        ->assertRedirect('/login');
});

it('allows authenticated users access to the panel', function () {
    $this->asUser()->get('/')
        ->assertStatus(200);
});
