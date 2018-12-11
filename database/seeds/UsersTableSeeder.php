<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'User',
            'email' => env('USER_EMAIL_1'),
            'coins' => 180,
            'password' => bcrypt(env('USER_PASSWORD_1'))
        ]);

        \App\Models\User::create([
            'name' => 'Test',
            'email' => env('USER_EMAIL_2'),
            'coins' => 380,
            'password' => bcrypt(env('USER_PASSWORD_2'))
        ]);

        factory(\App\Models\User::class, 10)->create()->each(function ($user) {
            $user->games()->save(factory(\App\Models\Game::class)->states('waiting')->make());
        });

        for ($i = 2; $i <= 10; $i += 2) {
            \App\Models\UserFriend::create([
                'user_id' => 1,
                'friend_id' => $i
            ]);
            \App\Models\UserFriend::create([
                'user_id' => $i,
                'friend_id' => 1
            ]);
        }

        \DB::table('pack_user')->insert([
            'user_id' => 1,
            'pack_id' => 1,
        ]);

        factory(\App\Models\User::class, 1)->states('admin')->create();
    }
}
