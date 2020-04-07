<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    if(User::clientUsers()->count() == 0){
        factory(User::class)->state('client')->create();
    }
    if (Practice::all()->count() == 0) {
        factory(Practice::class)->create();
    }

    $clientIds = User::clientUsers()->pluck('id')->toArray();
    $practiceIds = Practice::all()->pluck('id')->toArray();

    return [
        'name' => $faker->domainWord,
        'hasOrals' => $faker->boolean,
        'hasValueTargeting' => $faker->boolean,

        'progressSetUp' => $faker->numberBetween(0, 40),
        'progressValue' => $faker->numberBetween(0, 20),
        'progressResponse' => $faker->numberBetween(0, 25),
        'progressAnalytics' => $faker->numberBetween(0, 10),
        'progressConclusions' => $faker->numberBetween(0, 5),

        'deadline' => $faker->dateTimeBetween('+1 month', '+30 months'),

        'client_id' => $faker->randomElement($clientIds),
        'practice_id' => $faker->randomElement($practiceIds),
    ];
});


$factory->state(Project::class, 'open', [
    'currentPhase' => 'open',
]);

$factory->state(Project::class, 'preparation', [
    'currentPhase' => 'preparation',
]);

$factory->state(Project::class, 'old', [
    'currentPhase' => 'old',
]);
