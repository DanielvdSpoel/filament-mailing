<?php

namespace Database\Factories;

use App\Models\InboxTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InboxTemplateFactory extends Factory
{
    protected $model = InboxTemplate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
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
