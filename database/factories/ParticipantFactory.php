<?php

use Faker\Generator as Faker;

$factory->define(\App\Participant::class, function(Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail
    ];
});