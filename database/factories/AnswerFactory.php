<?php

use App\Models\Answer;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'body'        => $faker->paragraphs(rand(3,7), true),
        'user_id'     => User::pluck('id')->random(),
        'votes_count' => rand(-3,10),
    ];
});
