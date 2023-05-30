<?php

namespace Database\Seeders;

use App\Models\Transmitter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransmittersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transmitters = [
            [
                'id' => '1',
                'name' => 't16 sz',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '2',
                'name' => 't16 iz',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '3',
                'name' => 't16 izs',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '4',
                'name' => 't18 sz',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '5',
                'name' => 't18 mz-wc',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '6',
                'name' => '32 mz',
                'manufacturer' => 'Futaba'
            ],
            [
                'id' => '7',
                'name' => 'NX8',
                'manufacturer' => 'Spektrum'
            ],
            [
                'id' => '8',
                'name' => 'DX6e',
                'manufacturer' => 'Spektrum'
            ],
            [
                'id' => '9',
                'name' => 'iX20',
                'manufacturer' => 'Spektrum'
            ],
            [
                'id' => '10',
                'name' => 'NX10',
                'manufacturer' => 'Spektrum'
            ]

        ];
        Transmitter::insert($transmitters);
    }
}
