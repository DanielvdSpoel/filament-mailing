<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Account::factory()->create([
            'name' => 'DanielvdSpoel',
        ])->users()->attach(
            User::factory()->create([
                'name' => 'Daniël van der Spoel',
                'email' => 'contact@danielvdspoel.nl',
            ])
        );

        $this->call([
            InboxTemplateSeeder::class,
        ]);
    }
}
