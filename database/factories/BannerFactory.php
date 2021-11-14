<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'is_button_available' => $this->faker->randomElement(Banner::IS_BUTTON_AVAILABLE),
            'button_text' => $this->faker->sentence(),
            'link' => $this->faker->url(),
            'title' => $title,
            'sub_title' => $title,
            'banner_template_code' => $this->faker->randomElement(Banner::BANNER_TEMPLATE_TYPES),
            'alt_image_title' => $this->faker->word(),
            'alt_image_title_en' => $this->faker->word(),
            'banner_image_url' => $this->faker->imageUrl()
        ];
    }
}
