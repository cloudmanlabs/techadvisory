<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GeneralInfoQuestion;
use App\Model;
use Faker\Generator as Faker;

$factory->define(GeneralInfoQuestion::class, function (Faker $faker) {
    return [
        'question' => 'How are you?',
        'type' => $faker->randomElement(GeneralInfoQuestion::questionTypes)
    ];
});
