<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rcModelEngines = [
            [
                'rc_model_id' => 1,
                'engine_id' => 1,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 2,
                'engine_id' => 2,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 3,
                'engine_id' => 1,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 4,
                'engine_id' => 1,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 4,
                'engine_id' => 2,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 5,
                'engine_id' => 1,
                'quantity' => 2
            ],
        ];
        
        DB::table('rc_models_has_engines')->insert($rcModelEngines);

        $rcModelPropellers = [
            [
                'rc_model_id' => 1,
                'propeller_id' => 1,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 2,
                'propeller_id' => 2,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 3,
                'propeller_id' => 3,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 4,
                'propeller_id' => 1,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 4,
                'propeller_id' => 2,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 5,
                'propeller_id' => 1,
                'quantity' => 2
            ],
        ];

        DB::table('rc_models_has_propellers')->insert($rcModelPropellers);

        $rcModelBatteries = [
            [
                'rc_model_id' => 1,
                'battery_id' => 50,
                'quantity' => 1
            ],
            [
                'rc_model_id' => 1,
                'battery_id' => 58,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 2,
                'battery_id' => 71,
                'quantity' => 3
            ],
            [
                'rc_model_id' => 3,
                'battery_id' => 50,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 4,
                'battery_id' => 75,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 4,
                'battery_id' => 110,
                'quantity' => 2
            ],
            [
                'rc_model_id' => 5,
                'battery_id' => 123,
                'quantity' => 2
            ],
        ];

        DB::table('rc_models_has_batteries')->insert($rcModelBatteries);
    }
}
