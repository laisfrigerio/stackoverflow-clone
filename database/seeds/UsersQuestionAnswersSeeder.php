<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersQuestionAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 3)->create()->each(function ($user) {
            $user->questions()
                ->saveMany(
                    factory(Question::class, rand(1,5))->make()
                )->each(function ($question) {
                    $question->answers()
                        ->saveMany(
                            factory(Answer::class, rand(1,5))->make()
                        );
                });
        });
    }
}
