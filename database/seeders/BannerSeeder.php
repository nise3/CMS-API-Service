<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('banners')->truncate();
        DB::table('banners')->insert(array(
            array('id' => '1','slider_id' => '1','title_en' => NULL,'title' => 'উদযাপন অনুষ্ঠান','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '1','button_text' => 'আরো দেখুন','link' => 'http://mcci.nise.gov.bd/contact','image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => 'BT_RL','banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/K3CPNhT6O9pkjiyMAMqHfXaV661lRw1644470839.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:29:01','updated_at' => '2022-02-10 23:27:04','deleted_at' => NULL),
            array('id' => '2','slider_id' => '1','title_en' => 'Inauguration','title' => 'উদ্বোধন','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => 'BT_CB','banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/RCx5sshCZ2uWfPvqRggVkoYrh1x72E1644474842.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:32:47','updated_at' => '2022-02-10 18:34:07','deleted_at' => NULL),
            array('id' => '3','slider_id' => '2','title_en' => 'NISE ব্যানার','title' => 'NISE Banner','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => 'আরো দেখুন','link' => 'http://nise.gov.bd/jobs','image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => 'BT_OB','banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/ItEDBJGphYHviPMXTG6IT0ihEglKfC1644473510.png','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:39:52','updated_at' => '2022-02-17 20:51:50','deleted_at' => NULL),
            array('id' => '4','slider_id' => '2','title_en' => 'slider -2','title' => 'slider -2','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => 'আরো দেখুন','link' => 'http://nise.gov.bd/jobs','image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => 'BT_OB','banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/mYn9MSJkuxYYYgkZru8crePJXDJVpz1644473528.png','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 17:49:30','updated_at' => '2022-02-17 20:52:01','deleted_at' => NULL),
            array('id' => '5','slider_id' => '3','title_en' => 'Department of Youth Development - Government of the People\'s Republic of Bangladesh','title' => 'যুব উন্নয়ন অধিদপ্তর - গণপ্রজাতন্ত্রী বাংলাদেশ সরকার','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => NULL,'banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/flMZYWGmMWSbagKXUmAg7i41Bys2C01644485885.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 21:34:44','updated_at' => '2022-02-10 21:38:09','deleted_at' => NULL),
            array('id' => '6','slider_id' => '3','title_en' => 'Golden Jubilee of Independence','title' => 'স্বাধীনতার সুবর্ণজয়ন্তী','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => NULL,'banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/2NfWMGS0Gu5b3r9j9P23gPhOE52vwa1644486057.jpg','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-10 21:41:02','updated_at' => '2022-02-10 21:41:02','deleted_at' => NULL),
            array('id' => '7','slider_id' => '4','title_en' => 'ins-banner','title' => 'ইন-ব্যানার','sub_title_en' => NULL,'sub_title' => NULL,'is_button_available' => '0','button_text' => NULL,'link' => NULL,'image_alt_title_en' => NULL,'image_alt_title' => NULL,'banner_template_code' => NULL,'banner_image_path' => 'https://file-phase1.nise.gov.bd/uploads/w9xsdJ0gSXa2p2c3PYMiVaVsW6NwiB1644836273.png','row_status' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => '2022-02-14 22:58:17','updated_at' => '2022-02-14 22:58:17','deleted_at' => NULL)
        ));

        Schema::enableForeignKeyConstraints();
    }
}
