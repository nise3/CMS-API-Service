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
        $this->call(GalleryAlbumSeeder::class);
        $this->call(GalleryImageVideoSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(LanguageCodeSeeder::class);
        $this->call(LanguageConfigSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CalenderEventSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(StaticPageSeeder::class);
        $this->call(NoticeOrNewsSeeder::class);
        $this->call(RecentActivitySeeder::class);
        $this->call(Nise3PartnerSeeder::class);
        $this->call(VisitorFeedbackSuggestionSeeder::class);
        $this->call(StaticPageTypeSeeder::class);
    }
}
