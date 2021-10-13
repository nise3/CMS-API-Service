<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticPageFactory extends Factory
{
    protected $model = StaticPage::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement([1, 2]),
            'page_id' => $this->faker->sentence(),
            'description_en' => $this->faker->sentence(40),
            'description' => $this->faker->sentence(40),
            "content_type" => $this->faker->randomElement([1, 2, 3]),
            "content_path" => $this->faker->sentence(),
            "content_properties" => $this->faker->sentence(),
            'page_contents' => $this->faker->sentence(20),
            'alt_title_en' => $this->faker->word(),
            'alt_title' => $this->faker->word(),
            'title_en' => $title,
            'title' => $title
        ];
    }
}
