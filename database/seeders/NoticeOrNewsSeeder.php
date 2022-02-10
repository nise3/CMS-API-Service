<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\NoticeOrNews;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Matcher\Not;

class NoticeOrNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('notice_or_news')->truncate();
        DB::table('notice_or_news')->insert([
            array('type' => '2','show_in' => '3','published_at' => '2022-01-03 00:00:00','archived_at' => NULL,'title_en' => 'Computer circular has started','title' => 'কম্পিউটার সার্কুলার শুরু হয়েছে','institute_id' => '2','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/fS3aBIHTUHysbHBhcmlLohdxN8oXSS1641890506.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-01-11 20:41:57','updated_at' => '2022-01-11 20:43:34','deleted_at' => NULL),
            array('type' => '1','show_in' => '3','published_at' => '2022-02-01 00:00:00','archived_at' => NULL,'title_en' => 'Notification has been published.','title' => 'বিজ্ঞপ্তি প্রকাশ করা হয়েছে।','institute_id' => '2','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/w0vU9GIrxZezZwKs7C0yOa6JEETzhM1644215978.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => 'abc','file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 18:39:55','updated_at' => '2022-02-07 18:39:55','deleted_at' => NULL),
            array('type' => '2','show_in' => '3','published_at' => '2022-02-07 00:00:00','archived_at' => '2022-03-10 00:00:00','title_en' => 'There will be cultural events','title' => 'সাংস্কৃতিক অনুষ্ঠান হবে','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/rkqXYlkfuKWhiK19voAttUXqe23K8e1644234493.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:48:25','updated_at' => '2022-02-07 23:48:25','deleted_at' => NULL),
            array('type' => '1','show_in' => '3','published_at' => '2022-02-07 00:00:00','archived_at' => '2022-03-02 00:00:00','title_en' => 'Notification has been published.','title' => 'বিজ্ঞপ্তি প্রকাশ করা হয়েছে।','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/LcnNfbzNn4cGB2HX74ly84y1Vlmecv1644234875.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:54:41','updated_at' => '2022-02-07 23:54:41','deleted_at' => NULL),
            array('type' => '1','show_in' => '3','published_at' => '2022-02-10 00:00:00','archived_at' => '2022-03-12 00:00:00','title_en' => 'Freelancing courses are no longer available this fiscal year','title' => 'এই অর্থবছরের আর ফ্রিল্যান্সিং কোর্স হচ্ছে না','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/S5aKWed7wWVueMBHFz4zfHJiGfnVhA1644234920.png','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:55:26','updated_at' => '2022-02-07 23:55:26','deleted_at' => NULL),
            array('type' => '1','show_in' => '3','published_at' => '2022-02-08 00:00:00','archived_at' => '2022-02-23 00:00:00','title_en' => NULL,'title' => 'কম্পিউটার সার্কুলার','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/fadWoDkNDVSFVD8vcORPYSgdHZ8z1N1644234974.png','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => 'https://file.nise3.xyz/uploads/2WYzb6e6E0NqVC0Rsq78L9uK0lYLkE1644234965.pdf','file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:56:21','updated_at' => '2022-02-07 23:56:21','deleted_at' => NULL),
            array('type' => '2','show_in' => '3','published_at' => '2022-02-07 00:00:00','archived_at' => '2022-02-18 00:00:00','title_en' => 'Allocations are being distributed','title' => 'বরাদ্ধ বিতরণ হচ্ছে','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/r79dZKLqTT2bB7F2rqSEvFMJITaXWC1644235016.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:57:01','updated_at' => '2022-02-07 23:57:01','deleted_at' => NULL),
            array('type' => '1','show_in' => '3','published_at' => '2022-02-08 00:00:00','archived_at' => '2022-03-03 00:00:00','title_en' => 'Computer training is starting','title' => 'কম্পিউটার প্রশিক্ষণ শুরু হচ্ছে','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'details' => NULL,'details_en' => NULL,'main_image_path' => 'https://file.nise3.xyz/uploads/pydUNs9Qk0kZnuy4kb9BaYVjdP7OuM1644235052.jpg','grid_image_path' => NULL,'thumb_image_path' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'file_path' => NULL,'file_alt_title_en' => NULL,'file_alt_title' => NULL,'row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-07 23:57:38','updated_at' => '2022-02-07 23:57:38','deleted_at' => NULL)
        ]);
        Schema::disableForeignKeyConstraints();

    }
}
