<?php

use App\GeneralInfoQuestion;
use App\Practice;
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
            'page' => 'project_info',
            'type' => 'textarea',
            'label' => 'Short Description',
            'required' => true
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'text',
            'label' => 'Client contact e-mail',
            'placeholder' => 'Client contact e-mail',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'text',
            'label' => 'Client contact phone',
            'placeholder' => 'Client contact phone',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'text',
            'label' => 'Accenture contact e-mail',
            'placeholder' => 'Accenture contact e-mail',
            'required' => false
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'text',
            'label' => 'Accenture contact phone',
            'placeholder' => 'Accenture contact phone',
            'required' => false
        ]);

        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'selectSingle',
            'label' => 'Project Currency',
            'placeholder' => 'Please select the Project Currency',
            'required' => true,
            'presetOption' => 'currencies',
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'project_info',
            'type' => 'textarea',
            'label' => 'Detailed description',
            'required' => false
        ]);

        $transportPractice = Practice::where('name', 'Transport')->first();
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'scope',
            'type' => 'selectMultiple',
            'label' => 'Transport Flows',
            'required' => false,
            'presetOption' => 'transportFlows',
            'practice_id' => $transportPractice->id
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'scope',
            'type' => 'selectMultiple',
            'label' => 'Transport Mode',
            'required' => false,
            'presetOption' => 'transportModes',
            'practice_id' => $transportPractice->id
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'scope',
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'required' => false,
            'presetOption' => 'transportTypes',
            'practice_id' => $transportPractice->id
        ]);

        $planningPractice = Practice::where('name', 'Planning')->first();
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'scope',
            'type' => 'text',
            'label' => 'Planning question 1',
            'placeholder' => 'Placeholder',
            'required' => false,
            'practice_id' => $planningPractice->id
        ]);


        factory(GeneralInfoQuestion::class)->create([
            'page' => 'timeline',
            'type' => 'date',
            'label' => 'Tentative date for project setup completion',
            'required' => false,
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'timeline',
            'type' => 'date',
            'label' => 'Tentative date for Value Targeting completion',
            'required' => false,
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'timeline',
            'type' => 'date',
            'label' => 'Tentative date for Vendor Response completion',
            'required' => false,
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'timeline',
            'type' => 'date',
            'label' => 'Tentative date for Analytics completion',
            'required' => false,
        ]);
        factory(GeneralInfoQuestion::class)->create([
            'page' => 'timeline',
            'type' => 'date',
            'label' => 'Tentative date fot Conclusions & Recomendations completion',
            'required' => false,
        ]);
    }
}
