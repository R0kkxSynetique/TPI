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
            ]
        ];
        Propeller::insert($propellers);
    }
}
