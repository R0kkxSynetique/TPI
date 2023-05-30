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
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 450,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 450,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 1800,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 1800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 2000,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 2500,
                'cells' => 2,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 2800,
                'cells' => 3,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 2800,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 3000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 4000,
                'cells' => 4,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 5000,
                'cells' => 5,
                'type' => 'LiPo',
                'cRate' => 50
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 10
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 15
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 20
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 25
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 30
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 35
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 40
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 45
            ],
            [
                'capacity' => 6000,
                'cells' => 6,
                'type' => 'LiPo',
                'cRate' => 50
            ]
        ];
        Battery::insert($rcModelBatteries);
    }
}
