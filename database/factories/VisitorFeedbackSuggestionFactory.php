<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\VisitorFeedbackSuggestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFeedbackSuggestionFactory extends Factory
{
    protected $model = VisitorFeedbackSuggestion::class;


    public function definition(): array
    {
    	return [
            'form_type' => $this->faker->randomElement(VisitorFeedbackSuggestion::Form_Type),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name(),
            'name_en' => $this->faker->name(),
            'mobile'=>$this->faker->regexify('01[3-9]\d{8}'),
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->sentence,
            'address_en' => $this->faker->sentence,
            'comment' => $this->faker->paragraph,
            'comment_en' => $this->faker->paragraph
    	];
    }
}
