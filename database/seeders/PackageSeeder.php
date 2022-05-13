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
        ]);

        Package::create([
            'type' => 'daily',
            'unlock_price' => 0,
        ]);
        
    }
}
