<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Question::class, 10)->states('science_category', 'select_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('language_category', 'select_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('drama_category', 'select_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('art_and_design_category', 'select_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('not_right')->make());
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('science_category', 'text_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('language_category', 'text_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('drama_category', 'text_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

        factory(\App\Models\Question::class, 10)->states('art_and_design_category', 'text_type')->create()->each(function ($question) {
            $question->answers()->save(factory(\App\Models\Answer::class)->states('right')->make());
        });

    }
}
