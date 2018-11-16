<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->all();
        $numberOfUsers = count($users);

        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }
    }
}
