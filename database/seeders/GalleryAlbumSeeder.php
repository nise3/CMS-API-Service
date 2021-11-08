<?php

namespace Database\Seeders;

use App\Models\GalleryImageVideo;
use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

class GalleryAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            GalleryAlbum::factory()
                ->has(GalleryImageVideo::factory()->count(2))
                ->count(10)
                ->create();


    }
}
