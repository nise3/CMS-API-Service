<?php

namespace Database\Seeders;

use App\Models\CalenderEvent;
use Illuminate\Database\Seeder;

class CalenderEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalenderEvent::factory()->count(300)->create();
    }
}
