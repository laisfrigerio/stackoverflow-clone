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

}
