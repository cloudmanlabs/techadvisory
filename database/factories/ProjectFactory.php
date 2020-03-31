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

$factory->state(Project::class, 'withPractice', [
    'practice_id' => 1,
]);
$factory->state(Project::class, 'withClient', [
    'client_id' => 1,
]);


$factory->state(Project::class, 'open', [
    'currentPhase' => 'open',
]);

$factory->state(Project::class, 'preparation', [
    'currentPhase' => 'preparation',
]);

$factory->state(Project::class, 'old', [
    'currentPhase' => 'old',
]);
