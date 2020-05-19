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
            'page' => 'vendor_market',

            'label' => 'Countries',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_countries'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'fitgap',
            'label' => 'Vendor contact role',
            'type' => 'text',
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

            'label' => 'Solutions used',
            'type' => 'text',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_solutions_used'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'Deliverables per phase',
            'type' => 'empty',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_deliverables_per_phase'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'RACI Matrix',
            'type' => 'empty',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_raci_matrix'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation',

            'label' => 'Implementation Cost',
            'type' => 'empty',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_implementation_implementation_cost'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Pricing model description',
            'type' => 'text',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_pricing_model_description'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Pricing model response',
            'type' => 'text',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_pricing_model_response'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Pricing model Upload',
            'type' => 'file',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_pricing_model_upload'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Estimate first 5 years billing plan',
            'type' => 'empty',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_estimate_5_years'
        ]);

        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Detailed breakdown response',
            'type' => 'text',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_detailed_breakdown_response'
        ]);
        factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run',

            'label' => 'Detailed breakdown Upload',
            'type' => 'file',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'implementation_run_detailed_breakdown_upload'
        ]);
    }
}
