<?php

use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title'         => rtrim($faker->sentence(rand(5,10)), '.'),
        'body'          => $faker->paragraphs(rand(3,7), true),
        'views'         => rand(0,10),
        'votes'         => rand(-3,10),
    ];
});
