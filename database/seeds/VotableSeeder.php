<?php
    
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class VotableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::pluck('id')->all();
        $numberOfUsers = count($users);
        $votes = [-1, 1];
        
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $question->votes()->attach($user, ['vote' => $votes[rand(0, 1)]]);
            }
        }
    
        foreach (Answer::all() as $answer) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $answer->votes()->attach($user, ['vote' => $votes[rand(0, 1)]]);
            }
        }
    }
}
