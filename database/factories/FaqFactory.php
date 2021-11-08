<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
    	return [
            "show_in"=>BaseModel::SHOW_IN_NISE3,
            "institute_id"=>$this->faker->randomDigit(),
            "industry_association_id"=>$this->faker->randomDigit(),
            "organization_id"=>$this->faker->randomDigit(),
            "question"=>$this->faker->realText(100),
            "question_en"=>$this->faker->realText(100),
            "answer"=>$this->faker->realText,
            "answer_en"=>$this->faker->realText
    	];
    }
}
