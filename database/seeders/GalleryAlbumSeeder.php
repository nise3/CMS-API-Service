<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\GalleryImageVideo;
use App\Models\GalleryAlbum;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GalleryAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        GalleryAlbum::query()->truncate();
        for ($i = 0; $i < 10; $i++) {
            /** @var GalleryAlbum $galleryAlbum */
            $galleryAlbum = GalleryAlbum::factory()->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $galleryAlbum->getTable(),
                            "key_id" => $galleryAlbum->id,
                            'lang_code' => 'hi',
                            'column_name' => GalleryAlbum::LANGUAGE_ATTR_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी "
                        ],
                        [
                            'table_name' => $galleryAlbum->getTable(),
                            "key_id" => $galleryAlbum->id,
                            'lang_code' => 'hi',
                            'column_name' => GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "भारत का इतिहासं"
                        ],
                        [
                            'table_name' => $galleryAlbum->getTable(),
                            "key_id" => $galleryAlbum->id,
                            'lang_code' => 'te',
                            'column_name' => GalleryAlbum::LANGUAGE_ATTR_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $galleryAlbum->getTable(),
                            "key_id" => $galleryAlbum->id,
                            'lang_code' => 'te',
                            'column_name' => GalleryAlbum::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ]
                    )
                )
                ->count(4)
                ->create();
        }
        Schema::enableForeignKeyConstraints();

    }
}
