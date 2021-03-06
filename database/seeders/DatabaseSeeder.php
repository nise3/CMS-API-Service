<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GeoLocationDatabaseSeeder::class);
        $this->call(StaticPageTypeSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(LanguageCodeSeeder::class);
        $this->call(LanguageConfigSeeder::class);
        $this->call(NoticeOrNewsSeeder::class);
        $this->call(StaticPageBlocksSeeder::class);
        $this->call(StaticPageContentsSeeder::class);
        $this->call(RecentActivitySeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(FaqSeeder::class);
    }
}
