<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'hasOrals' => false,
        'hasValueTargeting' => false,

        'progressSetUp' => 0,
        'progressValue' => 0,
        'progressResponse' => 0,
        'progressAnalytics' => 0,
        'progressConclusions' => 0,
    ];
});
