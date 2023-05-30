<?php

namespace Database\Seeders;

use App\Models\Propeller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propellers = [
            [
                'size' => '27x10',
                'type' => 'bois',
                'blade_number' => 2
            ],
            [
                'size' => '26x12',
                'type' => 'bois',
                'blade_number' => 2
            ],
            [
                'size' => '26x13',
                'type' => 'bois',
                'blade_number' => 2
            ],
            [
                'size' => '20x8',
                'type' => 'bois',
                'blade_number' => 2
            ],
            [
                'size' => '22x10',
                'type' => 'bois',
                'blade_number' => 2
            ],
            [
                'size' => '18x6',
                'type' => 'apc',
                'blade_number' => 3
            ],
            [
                'size' => '16x8',
                'type' => 'apc',
                'blade_number' => 3
            ],
            [
                'size' => '12x6',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '11x7',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '10x4.5',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '9x6',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '8x4',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '7x5',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '6x3',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '5x3',
                'type' => 'apc',
                'blade_number' => 2
            ],
            [
                'size' => '4.5x3',
                'type' => 'apc',
                'blade_number' => 2
            ]
        ];
        Propeller::insert($propellers);
    }
}
