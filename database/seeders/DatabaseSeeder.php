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
        $this->call(CountryTableSeeder::class);
        $this->call(LanguageCodeSeeder::class);
        $this->call(LanguageConfigSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CalenderEventSeeder::class);
    }
}
