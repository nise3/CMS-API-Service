<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('sliders')->truncate();

        DB::table('sliders')->insert(array(
            array('id' => '1','title' => 'MCCI-slider1','title_en' => 'MCCI-slider1','show_in' => '5','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => '1','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:26:54','updated_at' => '2022-02-10 17:26:54','deleted_at' => NULL),
            array('id' => '2','title' => 'NASCIB-slider','title_en' => 'NASCIB-slider','show_in' => '5','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => '2','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:26:54','updated_at' => '2022-02-10 17:26:54','deleted_at' => NULL),
            array('id' => '3','title' => 'nise-slider','title_en' => 'nise-slider','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:38:40','updated_at' => '2022-02-10 17:38:40','deleted_at' => NULL),
            array('id' => '4','title' => 'DYD-slider','title_en' => 'DYD-slider','show_in' => '3','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 21:32:18','updated_at' => '2022-02-10 21:32:18','deleted_at' => NULL),
            array('id' => '5','title' => 'ins-slider','title_en' => 'ins-slider','show_in' => '3','institute_id' => '2','organization_id' => NULL,'industry_association_id' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-14 22:57:13','updated_at' => '2022-02-14 22:57:13','deleted_at' => NULL)
        ));

        Schema::enableForeignKeyConstraints();
    }
}
