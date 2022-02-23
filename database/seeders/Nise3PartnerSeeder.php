<?php

namespace Database\Seeders;

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
            array('id' => '1','title_en' => NULL,'title' => 'সমাজসাব অধিদফতর','main_image_path' => 'https://file-phase1.nise.gov.bd/uploads/NxD7AROAbDL672P8FpYtjTBZQO5Dbn1644480571.png','thumb_image_path' => NULL,'grid_image_path' => NULL,'domain' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 20:09:32','updated_at' => '2022-02-10 20:09:32','deleted_at' => NULL),
            array('id' => '2','title_en' => NULL,'title' => 'বিটাক','main_image_path' => 'https://file-phase1.nise.gov.bd/uploads/JNgTosuI1YiP5ucrU430e4L3BgiYJf1644480605.jpg','thumb_image_path' => NULL,'grid_image_path' => NULL,'domain' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 20:10:10','updated_at' => '2022-02-10 20:10:10','deleted_at' => NULL),
            array('id' => '3','title_en' => NULL,'title' => 'যুব উন্নয়ন','main_image_path' => 'https://file-phase1.nise.gov.bd/uploads/1UIrTWVjmpZ11Z6ZmRHMfGHfWTL4Oz1644480620.jfif','thumb_image_path' => NULL,'grid_image_path' => NULL,'domain' => 'https://dyd-dev.nise3.xyz','image_alt_title_en' => NULL,'image_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 20:10:28','updated_at' => '2022-02-17 22:44:00','deleted_at' => NULL),
            array('id' => '4','title_en' => NULL,'title' => 'বিজিএমইএ','main_image_path' => 'https://file-phase1.nise.gov.bd/uploads/cBh2PfNmCKOvRh6ZBvz5vJhi3q9Db91644480638.png','thumb_image_path' => NULL,'grid_image_path' => NULL,'domain' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 20:10:44','updated_at' => '2022-02-10 20:10:44','deleted_at' => NULL)
        ));

        Schema::enableForeignKeyConstraints();
    }
}
