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
        $title = $this->faker->jobTitle();
        return [
            'show_in' => $this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'is_button_available' => $this->faker->randomElement([0,1]),
            'button_text'=>$this->faker->sentence(),
            'title' => $title,
            'sub_title' => $title
    	];
    }
}
