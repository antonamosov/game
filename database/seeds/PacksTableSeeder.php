<?php

use Illuminate\Database\Seeder;

class PacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Pack::class, 10)->create();

        \DB::table('category_pack')->insert([
            'category_id' => 1,
            'pack_id' => 1,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 4,
            'pack_id' => 2,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 2,
            'pack_id' => 3,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 3,
            'pack_id' => 3,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 1,
            'pack_id' => 4,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 2,
            'pack_id' => 4,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 3,
            'pack_id' => 4,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 1,
            'pack_id' => 5,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 2,
            'pack_id' => 5,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 3,
            'pack_id' => 5,
        ]);

        \DB::table('category_pack')->insert([
            'category_id' => 4,
            'pack_id' => 5,
        ]);
    }
}
