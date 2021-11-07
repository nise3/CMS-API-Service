<?php

namespace Database\Seeders;

use App\Models\LanguageConfig;
use Illuminate\Database\Seeder;

class LanguageConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $languages=[
           [
               "code" => "bn",
               "name" => "Bengali",
               "native_name" => "বাংলা",
               "is_native"=>1
           ],
           [
               "code" => "en",
               "name" => "English",
               "native_name" => "English",
               "is_native"=>0
           ],
           [
               "code" => "hi",
               "name" => "Hindi",
               "native_name" => "हिंदी",
               "is_native"=>0
           ],
           [
               "code" => "te",
               "name" => "Telugu",
               "native_name" => "తెలుగు",
               "is_native"=>0
           ]
       ];

       LanguageConfig::insert($languages);

    }
}
