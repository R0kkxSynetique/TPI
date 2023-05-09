<?php

namespace Database\Seeders;

use App\Models\RcModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RcModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aeromodels = [
            [
                'name' => 'Mitsubishi A6M Zero',
                'description' => 'Avion de chasse japonais',
                'manufacturer' => 'Meister Scale',
                'length' => '2580',
                'wingspan' => '3008',
                'height' => '800',
                'weight' => '16800',
                'user_id' => 1,
                'transmitter_id' => 1,
                'acquired_on' => '2016-02-19',
                'finished_on' => '2017-02-23',
                'first_flown_on' => '2017-03-09',
            ],
            [
                'name' => 'Hawker Hurricane',
                'description' => 'Avion de chasse anglais',
                'manufacturer' => null,
                'length' => null,
                'wingspan' => '2870',
                'height' => null,
                'weight' => '16300',
                'user_id' => 1,
                'transmitter_id' => 1,
                'acquired_on' => null,
                'finished_on' => null,
                'first_flown_on' => null,
            ],
            [
                'name' => 'Sopwith Triplane',
                'description' => 'Avion de chasse anglais',
                'manufacturer' => null,
                'length' => null,
                'wingspan' => '2800',
                'height' => null,
                'weight' => '15900',
                'user_id' => 1,
                'transmitter_id' => 1,
                'acquired_on' => null,
                'finished_on' => null,
                'first_flown_on' => null,
            ],
            [
                'name' => 'Consolidated B-24 Liberator',
                'description' => 'Avion de chasse anglais',
                'manufacturer' => null,
                'length' => null,
                'wingspan' => '3200',
                'height' => null,
                'weight' => '25000',
                'user_id' => 1,
                'transmitter_id' => 1,
                'acquired_on' => null,
                'finished_on' => null,
                'first_flown_on' => null,
            ],
            [
                'name' => 'de Havilland DH.98 Mosquito',
                'description' => 'Avion de chasse anglais',
                'manufacturer' => null,
                'length' => null,
                'wingspan' => '2950',
                'height' => null,
                'weight' => '18580',
                'user_id' => 1,
                'transmitter_id' => 1,
                'acquired_on' => null,
                'finished_on' => null,
                'first_flown_on' => null,
            ],
        ];
        RcModel::insert($aeromodels);
    }
}
