<?php

namespace Database\Seeders;

use App\Models\Flights;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = [
            [
                'location' => 'Vullierens',
                'date' => '2023-03-16',
                'time' => '14:32:00',
                'weather' => 'sunny',
                'duration' => '00:07:00',
                'description' => 'Vol d\'entrainement au show aérien',
                'rc_model_id' => 1,
            ]
        ];
        Flights::insert($flights);
    }
}
