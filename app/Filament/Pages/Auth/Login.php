<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Faker\Provider\Base;
use Filament\Pages\Auth\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (app()->hasDebugModeEnabled()) {
            $user = User::first();

            $this->form->fill([
                'email' => $user->email,
                'password' => 'password',
                'remember' => true,
            ]);
        }
    }

}
