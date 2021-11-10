<?php

namespace Database\Factories;

use App\Models\GalleryImageVideo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryImageVideoFactory extends Factory
{
    protected $model = GalleryImageVideo::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        $contentType = $this->faker->randomElement([1, 2]);
        $videoType = null;
        if ($contentType == 2) {
            $videoType = $this->faker->randomElement([1, 2]);
        }
        return [
            'featured'=>$this->faker->boolean(),
            'published_at' => Carbon::now(),
            'content_type' => $contentType,
            'video_type' =>$videoType,
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'content_title' => $this->faker->jobTitle(),
            'content_title_en' => $this->faker->jobTitle(),
            'content_description' => $this->faker->realText(),
            'content_description_en' => $this->faker->realText(),
            'alt_title' => $this->faker->realText(),
            'alt_title_en' => $title,
        ];
    }
}
