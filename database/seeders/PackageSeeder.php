<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'type' => 'payasyougo',
            'unlock_price' => 1,
        ])->save;

        Package::create([
            'type' => 'monthly',
            'unlock_price' => 0,
            'option1_price' => 19.99,
            'option2_price' => 44.99,
            'option3_price' => 79.99,
            'option1_nb' => 8,
            'option2_nb' => 25,
            'option3_nb' => 50,

        ]);

        Package::create([
            'type' => 'daily',
            'unlock_price' => 0,
        ]);
        
    }
}
