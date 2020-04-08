<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Practice;
use App\Subpractice;
use Faker\Generator as Faker;

$factory->define(Subpractice::class, function (Faker $faker) {
    if (Practice::all()->count() == 0) {
        factory(Practice::class)->create();
    }

    $practiceIds = Practice::all()->pluck('id')->toArray();

    return [
        'name' => $faker->domainWord,
        'practice_id' => $faker->randomElement($practiceIds),
    ];
});
