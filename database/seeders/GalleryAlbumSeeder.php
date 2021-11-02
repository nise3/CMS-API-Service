<?php

namespace Database\Seeders;

use App\Models\Gallery;
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
            ->has(Gallery::factory()->count(2))
            ->count(10)
            ->create();
    }
}
