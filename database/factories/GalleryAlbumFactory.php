<?php

namespace Database\Factories;

use App\Models\GalleryAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryAlbumFactory extends Factory
{
    protected $model = GalleryAlbum::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'title_en' => ucfirst($title),
            'title' => ucfirst($title),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'batch_id' => $this->faker->numberBetween(1, 10),
            'programme_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->sentence(),
            'featured' => $this->faker->boolean()
        ];
    }
}
