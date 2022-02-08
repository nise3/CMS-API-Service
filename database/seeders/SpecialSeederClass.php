<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpecialSeederClass extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            Schema::disableForeignKeyConstraints();

            DB::beginTransaction();

            DB::table('sliders')->truncate();
            DB::table('sliders')->insert([
                array('id' => '1', 'title' => 'MCCI-slider - 1', 'title_en' => 'MCCI-slider - 1', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-08 18:10:37', 'updated_at' => '2022-02-08 18:10:37', 'deleted_at' => NULL),
                array('id' => '2', 'title' => 'MCCI-slider - 2', 'title_en' => 'MCCI-slider - 2', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-08 18:25:34', 'updated_at' => '2022-02-08 18:29:48', 'deleted_at' => '2022-02-08 18:29:48')
            ]);

            DB::table('banners')->truncate();
            DB::table('banners')->insert([
                array('id' => '1','slider_id' => '1','title_en' => 'Club Orientation','title' => 'ক্লাব ওরিয়েন্টেশন','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => 'test','banner_template_code' => 'BT_CB','banner_image_path' => 'https://file.nise3.xyz/uploads/nEFOqd3mW7rYIXwHVegCKGvSZtfNw71644301858.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-01-16 18:24:30','updated_at' => '2022-02-08 18:31:34','deleted_at' => '2022-02-08 18:31:34'),
                array('id' => '2','slider_id' => '1','title_en' => 'Know Ourself','title' => 'আমাদের সম্পর্কে জানুন','sub_title_en' => NULL,'sub_title' => 'আপনি যদি একজন চাকরি প্রার্থী হয়ে থাকেন। তাহলে খুজের নিন আপনার প্রয়োজন এবং যোগ্যতা অনুসারে চাকরি তাহলে খুজের  নিন আপনার প্রয়োজন এবং যোগ্যতা অনুসারে চাকরি','is_button_available' => '1','button_text' => 'আরো দেখুন','link' => 'http://mcci.nise.asm/about-us','image_alt_title_en' => NULL,'image_alt_title' => 'slider1','banner_template_code' => 'BT_RL','banner_image_path' => 'https://file.nise3.xyz/uploads/8jf9TSnTEcIvKY7O5vaCBqIVawRndM1644301009.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-08 18:16:51','updated_at' => '2022-02-08 18:27:26','deleted_at' => NULL),
                array('id' => '3','slider_id' => '1','title_en' => 'Club Orientation','title' => 'ক্লাব ওরিয়েন্টেশন','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => 'BT_CB','banner_image_path' => 'https://file.nise3.xyz/uploads/JbLEBs2jM4mugljrJJbBBSL4f4bw9P1644301977.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-08 18:33:16','updated_at' => '2022-02-08 18:33:16','deleted_at' => NULL)
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }
}

