<?php

namespace Database\Seeders;

use App\Models\Engine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnginesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $engines = [
            [
                'name' => 'Fiala B2',
                'power' => '120cc',
                'type' => '95 SP 3.3%',
                'weight' => '3450',
                'frequency' => '4 temps',
                'user_id' => 1
            ],
            [
                'name' => 'Roto 85 FSI',
                'power' => '85cc',
                'type' => '95 SP 3.3%',
                'weight' => '3250',
                'frequency' => '4 temps',
                'user_id' => 1
            ]
        ];
        Engine::insert($engines);
    }
}
