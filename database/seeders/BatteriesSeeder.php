<?php

namespace Database\Seeders;

use App\Models\Battery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatteriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rcModelBatteries = [
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 2400,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2200,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
        ];
        Battery::insert($rcModelBatteries);
    }
}
