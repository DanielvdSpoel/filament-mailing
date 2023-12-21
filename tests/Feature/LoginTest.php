<?php

use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use function Pest\Livewire\livewire;

it('has a login page', function () {
    $this->get('/login')
        ->assertStatus(200);
});

it('redirects to dashboard if your already logged in', function () {
    $this->asUser()->get('/login')
        ->assertRedirect('/');
});

it('contains login information if the page is visited in debug mode', function () {
    $this->seed(DatabaseSeeder::class);
    config(['app.debug' => true]);
    $user = User::first();

    livewire(Login::class)
        ->assertFormSet([
            'email' => $user->email,
            'password' => 'password',
        ]);

    config(['app.debug' => env('app_debug')]);

});

it('does not login information if the page is visited without debug mode', function () {
    $this->seed(DatabaseSeeder::class);
    config(['app.debug' => false]);

    livewire(Login::class)
        ->assertFormSet([
            'email' => '',
            'password' => '',
        ]);

    config(['app.debug' => env('app_debug')]);

});

it('Can succesfully login', function () {
    $this->seed(DatabaseSeeder::class);
    $user = User::first();
    config(['app.debug' => true]);

    livewire(Login::class)
        ->call('authenticate')
        ->assertRedirect('/');

    $this->assertAuthenticatedAs($user);
    config(['app.debug' => env('app_debug')]);
});
