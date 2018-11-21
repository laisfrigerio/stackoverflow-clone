<?php
    
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Services\VoteService;
use Illuminate\Database\Seeder;

class VotableSeeder extends Seeder
{
    /**
     * @var VoteService
     */
    private $voteService;

    /**
     * VotableSeeder constructor.
     * @param VoteService $voteService
     */
    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1];
        
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users->get($i);
                $this->voteService->vote($user->questionsVote(), $question, $votes[rand(0, 1)]);
            }
        }

        foreach (Answer::all() as $answer) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users->get($i);
                $this->voteService->vote($user->answersVote(), $answer, $votes[rand(0, 1)]);
            }
        }
    }
}
