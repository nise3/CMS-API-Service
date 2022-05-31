<?php

namespace Database\Seeders;


use Carbon\Carbon;
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
            array('id' => '1','title' => 'আমাদের সম্পর্কে','title_en' => 'About Us','category' => '1','page_code' => 'about-us','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '2','title' => 'গোপনীয়তা নীতি','title_en' => 'Privacy Policy','category' => '1','page_code' => 'privacy-policy','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '3','title' => 'নাইস-৩ কিভাবে কাজ করে','title_en' => 'How Nise3 Works','category' => '2','page_code' => 'how-nise3-works-block','type' => '1','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '4','title' => 'নাইস-৩ কিভাবে কাজ করে','title_en' => 'How Nise3 Works','category' => '2','page_code' => 'how-nise3-works','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '5','title' => 'নিজেকে যাচাই করুন','title_en' => 'Self Assessment','category' => '2','page_code' => 'self-assessment','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '6','title' => 'নিজেকে যাচাই করুন','title_en' => 'Self Assessment','category' => '2','page_code' => 'self-assessment-block','type' => '1','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '7','title' => 'প্রতিষ্ঠানের বিস্তারিত','title_en' => 'Institute details','category' => '4','page_code' => 'institute-details','type' => '1','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '8','title' => 'শর্তাবলী','title_en' => 'Terms and conditions','category' => '1','page_code' => 'terms-and-conditions','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '9','title' => 'ক্যারিয়ার পরামর্শ','title_en' => 'Career Advice ','category' => '1','page_code' => 'career-advice','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '10','title' => 'নির্দেশিকা','title_en' => 'Guidelines','category' => '1','page_code' => 'guidelines','type' => '2','created_at' => '2022-01-06 05:31:07','updated_at' => '2022-01-06 05:31:07'),
            array('id' => '11','title' => 'আমাদের সম্পর্কে পেজ ব্লক','title_en' => 'About Us Page Block','category' => '6','page_code' => 'about-us-block','type' => '1','created_at' => '2022-02-07 23:44:11','updated_at' => '2022-02-07 23:44:11'),
            array('id' => '12','title' => 'আর. পি. এল. কি?','title_en' => 'What is RPL?','category' => '7','page_code' => 'what-is-rpl','type' => '2','created_at' => '2022-02-07 23:44:11','updated_at' => '2022-02-07 23:44:11'),
            array('id' => '13','title' => 'আর. পি. এল. সার্টিফিকেটের সুবিধা','title_en' => 'Benefits of RPL certificate','category' => '7','page_code' => 'rpl-certificate-benefits','type' => '2','created_at' => '2022-02-07 23:44:11','updated_at' => '2022-02-07 23:44:11'),
            array('id' => '14','title' => 'মাইগ্রেশন পোর্টালের বিস্তারিত','title_en' => 'Migration Portal Details','category' => '8','page_code' => 'migration-portal-details','type' => '1','created_at' => '2022-02-07 23:44:11','updated_at' => '2022-02-07 23:44:11'),
            array('id' => '15','title' => 'শ্রম কল্যান আতাশে','title_en' => 'Sromo Kalyan Atashe','category' => '8','page_code' => 'sromo-kalyan-atashe','type' => '2','created_at' => '2022-02-07 23:44:11','updated_at' => '2022-02-07 23:44:11'),
        ));
        Schema::enableForeignKeyConstraints();
    }
}
