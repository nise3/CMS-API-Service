<?php

namespace Database\Seeders;

use App\Models\VisitorFeedbackSuggestion;
use Illuminate\Database\Seeder;

class VisitorFeedbackSuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        VisitorFeedbackSuggestion::factory()->count(10)->create();

    }
}
