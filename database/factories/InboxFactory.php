<?php

namespace Database\Factories;

use App\Models\Inbox;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InboxFactory extends Factory
{
    protected $model = Inbox::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'inbox_template_id' => $this->faker->randomNumber(),
            'username' => $this->faker->userName(),
            'password' => bcrypt($this->faker->password()),
            'imap_host' => $this->faker->word(),
            'imap_port' => $this->faker->word(),
            'imap_encryption' => $this->faker->word(),
            'smtp_host' => $this->faker->word(),
            'smtp_port' => $this->faker->word(),
            'smtp_encryption' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
