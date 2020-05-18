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

        'deadline' => $faker->dateTimeBetween('+1 month', '+30 months'),
        'regions' => [$faker->randomElement(config('arrays.regions')), $faker->randomElement(config('arrays.regions')),],
        'industry' => $faker->randomElement(config('arrays.industryExperience')),

        'client_id' => $faker->randomElement($clientIds),
        'practice_id' => $faker->randomElement($practiceIds),

        'currentPhase' => 'preparation',

        'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
    ];
});


$factory->state(Project::class, 'open', [
    'currentPhase' => 'open',
    'step3SubmittedAccenture' => true,
    'step3SubmittedClient' => true,
    'step4SubmittedAccenture' => true,
    'step4SubmittedClient' => true,
]);

$factory->state(Project::class, 'old', [
    'currentPhase' => 'old',
    'step3SubmittedAccenture' => true,
    'step3SubmittedClient' => true,
    'step4SubmittedAccenture' => true,
    'step4SubmittedClient' => true,
]);
