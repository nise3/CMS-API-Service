<?php

namespace Database\Factories;

use App\Models\Nise3Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class Nise3PartnerFactory extends Factory
{
    protected $model = Nise3Partner::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle;

        return [
            'title_en' => $title,
            'title' => $title,
            'domain' => $this->faker->url,

        ];
    }
}
