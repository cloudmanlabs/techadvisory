<?php

use App\GeneralInfoQuestion;
use Illuminate\Database\Seeder;

class GeneralInfoQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'textarea',
            'label' => 'Short Description',
            'required' => true
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'text',
            'label' => 'Client contact e-mail',
            'placeholder' => 'Client contact e-mail',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'text',
            'label' => 'Client contact phone',
            'placeholder' => 'Client contact phone',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'text',
            'label' => 'Accenture contact e-mail',
            'placeholder' => 'Accenture contact e-mail',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'text',
            'label' => 'Accenture contact phone',
            'placeholder' => 'Accenture contact phone',
            'required' => false
        ]);

        factory(GeneralInfoQuestion::class)->create([
            'type' => 'selectSingle',
            'label' => 'Project Type',
            'placeholder' => 'Please select the Project Type',
            'required' => true,
            'options' => 'Business Case, Software selection, Value Based Software Selection, Client Satisfaction Survey',
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'selectSingle',
            'label' => 'Project Currency',
            'placeholder' => 'Please select the Project Currency',
            'required' => true,
            'options' => 'Euro, Dollar',
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'type' => 'textarea',
            'label' => 'Detailed description',
            'required' => false
        ]);
    }
}
