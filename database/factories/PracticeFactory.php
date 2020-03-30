<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Practice;
use Faker\Generator as Faker;

$factory->define(Practice::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
    ];
});
