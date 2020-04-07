<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subpractice;
use Faker\Generator as Faker;

$factory->define(Subpractice::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
    ];
});
