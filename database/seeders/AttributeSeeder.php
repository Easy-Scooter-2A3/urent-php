<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = ['Headgear', 'Tools', 'Food', 'Medicine', 'Clothes', 'Glasses', 'Bags', 'Shoes', 'Accessories'];

        foreach ($attributes as $key => $attribute) {
            Attribute::create([
                'name' => $attribute,
            ]);
        }
    }
}
