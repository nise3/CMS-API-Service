<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\RecentActivity;
use App\Models\StaticPageType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaticPageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('static_page_types')->truncate();

        DB::table('static_page_types')->insert(array(
            array('id' => '1', 'title_en' => 'About Us', 'title' => 'আমাদের সম্পর্কে', 'type' => 2, 'page_code' => 'about_us', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '2', 'title_en' => 'Privacy Policy', 'title' => 'গোপনীয়তা নীতি', 'type' => 2, 'page_code' => 'privacy_policy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '3', 'title_en' => 'How Nise3 Work', 'title' => 'নাইস-৩ কিভাবে কাজ করে', 'type' => 1, 'page_code' => 'how_nise3_work', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
