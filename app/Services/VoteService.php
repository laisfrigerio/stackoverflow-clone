<?php

namespace App\Services;

/**
 * Class VoteService
 * @package App\Services
 */
class VoteService
{
    /**
     * VoteService constructor.
     */
    public function __construct()
    {
        //
    }

    public function vote($relationship, $model, $vote)
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, [ 'vote' => $vote ]);
        } else {
            $relationship->attach($model, [ 'vote' => $vote ]);
        }

        $model->load('votes');
        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');
        $model->votes_counter = $upVotes + $downVotes;
        $model->save();

        return $model->votes_counter;
    }
}
