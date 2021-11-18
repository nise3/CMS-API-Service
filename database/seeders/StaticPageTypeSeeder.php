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
            array('id' => '1', 'category' => 1, 'title_en' => 'About Us', 'title' => 'আমাদের সম্পর্কে', 'type' => 2, 'page_code' => 'about-us', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '2', 'category' => 1, 'title_en' => 'Privacy Policy', 'title' => 'গোপনীয়তা নীতি', 'type' => 2, 'page_code' => 'privacy-policy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '3', 'category' => 2, 'title_en' => 'How Nise3 Works', 'title' => 'নাইস-৩ কিভাবে কাজ করে', 'type' => 1, 'page_code' => 'how-nise3-works', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '4', 'category' => 2, 'title_en' => 'Self Assessment', 'title' => 'নিজেকে যাচাই করুন', 'type' => 1, 'page_code' => 'self-assessment', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '5', 'category' => 4, 'title_en' => 'Institute details', 'title' => 'প্রতিষ্ঠানের বিস্তারিত', 'type' => 1, 'page_code' => 'institute_details', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '6', 'category' => 1, 'title_en' => 'শর্তাবলী', 'title' => 'Terms and conditions', 'type' => 2, 'page_code' => ' terms-and-conditions', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '7', 'category' => 2, 'title_en' => 'How Nise3 Works', 'title' => 'নাইস-৩ কিভাবে কাজ করে', 'type' => 1, 'page_code' => 'how-nise3-works', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('id' => '8', 'category' => 2, 'title_en' => 'How Nise3 Works', 'title' => 'নাইস-৩ কিভাবে কাজ করে', 'type' => 1, 'page_code' => 'how-nise3-works', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
        ));
        career-advice -> type(2)-> category-1
        Schema::enableForeignKeyConstraints();
    }
}
