<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Question::class, function (Faker $faker) {
        return [
            'title' => rtrim($faker->sentence(rand(5, 10)), '.'),
            'body' => $faker->paragraphs(rand(3,7), true),
            'views_count' => rand(0, 10),
            'votes_count' => rand(-10, 10)
        ];
});
