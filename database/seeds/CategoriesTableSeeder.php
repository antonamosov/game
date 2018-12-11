<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $names = [
            1 => 'Language',
            2 => 'Science',
            3 => 'Drama',
            4 => 'Art & Design'
        ];

        foreach (range(1, 4) as $index) {
            \App\Models\Category::create([
                'name' => $names[$index],
                'description' => $faker->unique()->text,
            ]);
        }
    }
}
