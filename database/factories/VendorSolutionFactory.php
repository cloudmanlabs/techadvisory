<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\VendorSolution;
use Faker\Generator as Faker;

$factory->define(VendorSolution::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord
    ];
});
