<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticPageFactory extends Factory
{
    protected $model = StaticPage::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'show_in' => $this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'content_type' => $this->faker->randomElement(StaticPage::CONTENT_TYPES),
            "content_slug_or_id" => $this->faker->word(),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'title_en' => $title,
            'title' => $title,
            'sub_title' => $title,
            'sub_title_en' => $title,
            'contents_en' => $this->faker->sentence(40),
            'contents' => $this->faker->sentence(40),

        ];
    }
}
