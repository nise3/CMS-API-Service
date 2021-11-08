<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\GalleryAlbum;
use App\Models\GalleryImageVideo;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GalleryImageVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        GalleryImageVideo::query()->truncate();
        $galleryAlbums = GalleryAlbum::all();
        foreach ($galleryAlbums as $galleryAlbum) {
            $galleryImageVideo = GalleryImageVideo::factory()
                ->state(
                    new sequence(
                        [
                            'gallery_album_id' => $galleryAlbum->id
                        ],
                    )
                )->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'hi',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी से सवाल"
                        ],
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'hi',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_DESCRIPTION,
                            'column_value' => "भारत का इतिहास या फिर भूगोलं तरर पो ल हो जाएंगी"
                        ],
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'hi',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_ALT_TITLE,
                            'column_value' => "भारत का इतिहास या फिर भूगोल,कीप्के ें हल हो जाएंगी"
                        ],
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'te',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'te',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_CONTENT_DESCRIPTION,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $galleryImageVideo->getTable(),
                            "key_id" => $galleryImageVideo->id,
                            'lang_code' => 'te',
                            'column_name' => GalleryImageVideo::LANGUAGE_ATTR_ALT_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ]
                    )
                )
                ->count(4)
                ->create();
        }
        Schema::disableForeignKeyConstraints();

    }
}
