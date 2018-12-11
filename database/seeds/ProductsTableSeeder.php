<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            \App\Models\Product::create([
                'coins' => $index * 1000,
                'price' => $index * 3 + 3.99
            ]);
        }
    }
}
