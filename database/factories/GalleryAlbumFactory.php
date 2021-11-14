<?php

namespace Database\Factories;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use Carbon\Carbon;
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
            'show_in' => $this->faker->randomElement(array_keys(BaseModel::SHOW_INS)),
            'album_type' => $this->faker->randomElement(GalleryAlbum::GALLERY_ALBUM_TYPES),
            'published_at' => Carbon::now(),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'industry_association_id' => $this->faker->numberBetween(1, 10),
            'batch_id' => $this->faker->numberBetween(1, 10),
            'program_id' => $this->faker->numberBetween(1, 10),
            'featured' => $this->faker->boolean(),
            'image_alt_title' => $this->faker->sentence(1),
            'image_alt_title_en' => $this->faker->sentence(1),
        ];
    }
}
