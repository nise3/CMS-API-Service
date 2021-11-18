<?php

namespace Database\Factories;

use App\Models\CalenderEvent;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CalenderEventFactory extends Factory
{
    protected $model = CalenderEvent::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        $date = Carbon::now();
        $startDate = $date->format('Y-m-d');
        $intRand = random_int(0, 365);
        $endDate = $date-> addDays($intRand)->format('Y-m-d');

    	return [
    	    "title" => $this->faker->text,
    	    "title_en" => $this->faker->text,
    	    "start_date" => $startDate,
    	    "end_date" => $endDate,
    	    "color" => $this->faker->hexColor
    	];
    }
}
