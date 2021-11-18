<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\RecentActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecentActivityFactory extends Factory
{
    protected $model = RecentActivity::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        $contentType = $this->faker->randomElement(RecentActivity::CONTENT_TYPES);
        $content_path = null;
        if ($contentType == RecentActivity::CONTENT_TYPE_IMAGE) {
            $content_path = $this->faker->imageUrl();
        }
        return [
            'title_en' => $title,
            'title' => $title,
            'show_in' => $this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'published_at' => Carbon::now(),
            'description_en' => $this->faker->sentence(40),
            'description' => $this->faker->sentence(40),
            'content_type' => $contentType,
            "image_path" => $content_path,
            "content_properties" => $this->faker->sentence()
        ];
    }
}
