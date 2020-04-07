<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\SizingQuestion;
use Faker\Generator as Faker;

$factory->define(SizingQuestion::class, function (Faker $faker) {
    $type = $faker->randomElement(SizingQuestion::questionTypes);

    switch ($type) {
        case 'text':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
                'placeholder' => 'Placeholder text'
            ];
        case 'textarea':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
            ];
        case 'selectSingle':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
                'placeholder' => 'Nothing selected',
                'presetOption' => 'custom',
                'options' => 'one, two, three'
            ];
        case 'selectMultiple':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
                'presetOption' => 'custom',
                'options' => 'one, two, three'
            ];
        case 'date':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
            ];
    }
});
