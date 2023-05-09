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
            ]
        ];
        Transmitter::insert($transmitters);
    }
}
