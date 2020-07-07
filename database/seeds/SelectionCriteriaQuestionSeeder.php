<?php

use App\SelectionCriteriaQuestion;
use Illuminate\Database\Seeder;

class SelectionCriteriaQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'fitgap',
            'label' => 'Vendor contact role',
            'type' => 'text',
        ]);


        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_market',

            'label' => 'Headquarters',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_headquarters'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_market',

            'label' => 'Commercial Offices',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_commercial'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_market',

            'label' => 'Service Team Offices',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_service'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_market',

            'label' => 'Geographies with solution implementations',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_geographies'
        ]);


        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience',
            'label' => 'Industry Experience',
            'type' => 'selectSingle',
            'presetOption' => 'industryExperience',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'experience_industry'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience',
            'label' => 'List all active clients',
            'type' => 'textarea',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'experience_clients'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience',
            'label' => 'List how many successful implementations you performed within last 4 years',
            'type' => 'textarea',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'experience_implementations'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience',
            'label' => 'Share 3 customer references for implementation with similar size & scope (same industry preferred)',
            'type' => 'textarea',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'experience_references'
        ]);


        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience',
            'label' => 'IT Enablers',
            'type' => 'selectSingle',
            'presetOption' => 'digitalEnablers',
        ]);




        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'Project plan',
            'type' => 'file',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_project_plan'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'Deliverables per phase',
            'type' => 'special',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_deliverables_per_phase'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'RACI Matrix',
            'type' => 'special',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_raci_matrix'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'Implementation Cost',
            'type' => 'special',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_implementation_cost'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Estimate first 5 years billing plan',
            'type' => 'special',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_estimate_5_years'
        ]);
    }
}
