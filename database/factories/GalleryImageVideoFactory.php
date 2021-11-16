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
        $contentType = $this->faker->randomElement(GalleryImageVideo::CONTENT_TYPES);
        $videoType = null;
        $imagePath = null;
        if ($contentType == GalleryImageVideo::CONTENT_TYPE_IMAGE) {
            $imagePath = $this->faker->imageUrl();
        } elseif ($contentType == GalleryImageVideo::CONTENT_TYPE_VIDEO) {
            $videoType = $this->faker->randomElement(GalleryImageVideo::VIDEO_TYPES);
        }
        return [
            'featured' => $this->faker->boolean(),
            'published_at' => Carbon::now(),
            'content_type' => $contentType,
            'video_type' => $videoType,
            'image_path' => $imagePath,
            'title' => $this->faker->jobTitle(),
            'title_en' => $this->faker->jobTitle(),
            'description' => $this->faker->realText(),
            'description_en' => $this->faker->realText(),
            'image_alt_title' => $this->faker->realText(),
            'image_alt_title_en' => $title,
        ];
    }
}
