<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'userType' => $faker->randomElement(['admin', 'accenture', 'client', 'vendor']),

        'hasFinishedSetup' => false
    ];
});

$factory->state(App\User::class, 'admin', [
    'userType' => 'admin',
]);

$factory->state(App\User::class, 'client', [
    'userType' => 'client',
]);

$factory->state(App\User::class, 'accenture', [
    'userType' => 'accenture',
]);

$factory->state(App\User::class, 'accentureAdmin', [
    'userType' => 'accentureAdmin',
]);

$factory->state(App\User::class, 'vendor', [
    'userType' => 'vendor',
]);




$factory->state(App\User::class, 'finishedSetup', [
    'hasFinishedSetup' => true
]);
