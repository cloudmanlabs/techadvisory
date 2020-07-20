<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\VendorSolutionQuestion;
use Faker\Generator as Faker;

$factory->define(VendorSolutionQuestion::class, function (Faker $faker) {
    $type = $faker->randomElement(VendorSolutionQuestion::questionTypes);

    switch ($type) {
        case 'text':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'placeholder' => 'Placeholder text'
            ];
        case 'textarea':
            return [
                'label' => 'How are you?',
                'type' => $type,
            ];
        case 'selectSingle':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'placeholder' => 'Nothing selected',
                'presetOption' => 'custom',
                'options' => 'one, two, three'
            ];
        case 'selectMultiple':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'presetOption' => 'custom',
                'options' => 'one, two, three'
            ];
        case 'date':
            return [
                'label' => 'How are you?',
                'type' => $type,
            ];
        case 'number':
            return [
                'label' => 'How are you?',
                'type' => $type,
            ];
        case 'email':
            return [
                'label' => 'How are you?',
                'type' => $type,
            ];
        case 'percentage':
            return [
                'label' => 'How are you?',
                'type' => $type,
            ];
    }
});
