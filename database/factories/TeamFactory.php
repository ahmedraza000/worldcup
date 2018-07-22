<?php

use Faker\Generator as Faker;
use App\Team;

$factory->define(Team::class, function (Faker $faker) {
    return [
        "team_name" => $faker->name,
        "country" => $faker->country,
        "group_name" => "A",
        "position" => 1
    ];
});
