<?php

use App\ClientProfileQuestion;
use Illuminate\Database\Seeder;

class ClientProfileQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ClientProfileQuestion::class)->create([
            'label' => 'Industry Experience',
            'type' => 'selectSingle',
            'presetOption' => 'industryExperience'
        ]);
        factory(ClientProfileQuestion::class)->create([
            'label' => 'Revenue for last exercise',
            'type' => 'number',
            'presetOption' => 'industryExperience',
            'placeholder' => 'Enter amount'
        ]);

        factory(ClientProfileQuestion::class)->create([
            'label' => 'Revenue currency',
            'type' => 'selectSingle',
            'presetOption' => 'currencies',
            'placeholder' => 'Please select your currency'
        ]);
        factory(ClientProfileQuestion::class)->create([
            'label' => 'Number of employees',
            'type' => 'selectSingle',
            'presetOption' => 'custom',
            'options' => '0-50, 50-500, 500-5.000, 5.000-30.000, +30.000',
            'placeholder' => 'Please select the range'
        ]);
        factory(ClientProfileQuestion::class)->create([
            'label' => 'Area served',
            'type' => 'selectSingle',
            'presetOption' => 'regions',
            'placeholder' => 'Please select the area served'
        ]);

        factory(ClientProfileQuestion::class)->create([
            'label' => 'Link to your website',
            'type' => 'text',
            'placeholder' => 'https://...'
        ]);
    }
}
