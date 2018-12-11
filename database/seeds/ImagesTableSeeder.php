<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 4) as $index) {
            \App\Images\Image::create([
                'source' => 'jpg',
                'owner_id' => $index,
                'owner_class' => 'categories'
            ]);
        }

        for ($ownerId = 1; $ownerId < 12; $ownerId++) {
            \App\Images\Image::create([
                'source' => 'jpg',
                'owner_id' => $ownerId,
                'owner_class' => 'users'
            ]);
        }

        for ($id = 20, $ownerId = 1; $id < 30; $id++, $ownerId++) {
            \App\Images\Image::create([
                'source' => 'jpg',
                'owner_id' => $ownerId,
                'owner_class' => 'packs'
            ]);
        }
    }
}
