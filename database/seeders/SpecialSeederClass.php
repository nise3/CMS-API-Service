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
                array('id' => '1', 'title' => 'MCCI-slider', 'title_en' => NULL, 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-08 18:10:37', 'updated_at' => '2022-02-08 18:10:37', 'deleted_at' => NULL),
                array('id' => '2', 'title' => 'MCCI-slider', 'title_en' => NULL, 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-08 18:25:34', 'updated_at' => '2022-02-08 18:29:48', 'deleted_at' => '2022-02-08 18:29:48')
            ]);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }
}

