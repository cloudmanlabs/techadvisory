<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GeneralInfoQuestion;
use App\Model;
use Faker\Generator as Faker;

$factory->define(GeneralInfoQuestion::class, function (Faker $faker) {
    $type = $faker->randomElement(GeneralInfoQuestion::questionTypes);

    switch($type){
        case 'text':
        case 'textarea':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
                'placeholder' => 'Placeholder text'
            ];
        case 'selectSingle':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'required' => $faker->boolean,
                'placeholder' => 'Nothing selected',
                'options' => 'one, two, three'
            ];
        case 'selectMultiple':
            return [
                'label' => 'How are you?',
                'type' => $type,
                'options' => 'one, two, three'
            ];
    }
});
