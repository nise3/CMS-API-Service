<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\NoticeOrNews;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeOrNewsFactory extends Factory
{
    protected $model = NoticeOrNews::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'type' => $this->faker->randomElement(NoticeOrNews::TYPES),
            'show_in'=>$this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'title_en' => $title,
            'title' => $title,
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'details_en' => $this->faker->sentence(40),
            'main_image_path' => $this->faker->imageUrl(),
            'details' => $this->faker->sentence(40),
            'published_at' => Carbon::now(),
            'file_path' => $this->faker->sentence(),
            'image_alt_title_en' => $this->faker->word(),
            'image_alt_title' => $this->faker->word(),
            'file_alt_title_en' => $this->faker->word(),
            'file_alt_title' => $this->faker->word(),
        ];
    }
}
