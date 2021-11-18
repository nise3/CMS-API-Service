<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'show_in' => $this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
