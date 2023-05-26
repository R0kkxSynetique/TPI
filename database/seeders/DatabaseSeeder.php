<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Flights;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory(1)->create([
            'email' => 'test@aero.ch',
        ]);
        $this->call([
            PropellersSeeder::class,
            EnginesSeeder::class,
            TransmittersSeeder::class,
            BatteriesSeeder::class,
            RcModelsSeeder::class,
            FlightsSeeder::class,
            LinksSeeder::class,
        ]);
    }
}
