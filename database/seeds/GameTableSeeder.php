<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Game;
use \App\Models\Turn;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Game::class, 1)->states('test_game')->create();

        $game = Game::create([
            'user_turn_id' => 1,
            'user_id' => 2,
            'opponent_id' => 1,
            'status' => Game::STATUS_ACTIVE,
            'category_id' => 1,
            'question_id' => 58,
            'user_answered' => false,
            'opponent_answered' => false,
            'user_glasses' => 0,
            'opponent_glasses' => 0,
            'round_number' => 3,
            'turn_number' => 3,
        ]);

        $game->Notifications()->delete();

        factory(\App\Models\Round::class, 1)->states('number_1')->create()->each(function($round) {
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_3')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_3')->make());
        });

        factory(\App\Models\Round::class, 1)->states('number_2')->create()->each(function($round) {
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_3')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_3')->make());
        });

        factory(\App\Models\Round::class, 1)->states('number_3')->create()->each(function($round) {
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_1')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_2')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_1', 'number_3', 'empty')->make());
            $round->Turns()->save(factory(Turn::class)->states('user_2', 'number_3', 'empty')->make());
        });
    }
}
