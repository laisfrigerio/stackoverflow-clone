<?php

namespace App\Traits;

use App\Models\User;

trait VotableTrait {

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable')
            ->withPivot('vote')
            ->withTimestamps();
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }
    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

}
