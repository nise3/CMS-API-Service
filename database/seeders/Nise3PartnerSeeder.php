<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Nise3Partner;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Nise3PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('nise3_partners')->truncate();

        DB::table('nise3_partners')->insert(array(
            array('id' => '1', 'title_en' => 'Avionics Technician', 'title' => 'Avionics Technician', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://www.wunsch.com/hic-voluptatem-sed-nobis-id-ab.html', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '2', 'title_en' => 'Health Technologist', 'title' => 'Health Technologist', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'https://www.hansen.com/dolores-est-ipsa-asperiores-cupiditate-aut-et-consequatur', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '3', 'title_en' => 'Poet OR Lyricist', 'title' => 'Poet OR Lyricist', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://pagac.org/aut-et-eos-enim-est-libero-nihil-maxime', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '4', 'title_en' => 'Safety Engineer', 'title' => 'Safety Engineer', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://wolf.com/molestiae-eius-dolore-quia-autem.html', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '5', 'title_en' => 'Grips', 'title' => 'Grips', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://www.bashirian.org/', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '6', 'title_en' => 'Bindery Worker', 'title' => 'Bindery Worker', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://bailey.com/et-dicta-qui-sequi-assumenda.html', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '7', 'title_en' => 'Word Processors and Typist', 'title' => 'Word Processors and Typist', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://zboncak.com/', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '8', 'title_en' => 'Hand Trimmer', 'title' => 'Hand Trimmer', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://www.corwin.com/', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '9', 'title_en' => 'Medical Records Technician', 'title' => 'Medical Records Technician', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://volkman.com/optio-voluptatem-autem-velit-doloremque-temporibus-rem-dolorum-maiores', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL),
            array('id' => '10', 'title_en' => 'Food Preparation and Serving Worker', 'title' => 'Food Preparation and Serving Worker', 'main_image_path' => NULL, 'thumb_image_path' => NULL, 'grid_image_path' => NULL, 'domain' => 'http://www.keeling.com/voluptatem-consequatur-est-atque-quaerat-quas-amet-et', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-01-05 17:31:07', 'updated_at' => '2022-01-05 17:31:07', 'deleted_at' => NULL)
        ));

        Schema::enableForeignKeyConstraints();
    }
}
