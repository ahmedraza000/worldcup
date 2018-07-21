<?php

use Faker\Generator as Faker;

$factory->define(\App\Player::class, function (Faker $faker) {
    return [
        "team_id" => 1,
        "firstname" => $faker->firstName,
        "lastname" => $faker->lastName,
        "age" => $faker->numberBetween(20, 40),
        "position" => "position",
    ];
});
