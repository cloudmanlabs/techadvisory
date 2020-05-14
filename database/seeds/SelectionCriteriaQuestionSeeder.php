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

            'label' => 'Solutions used',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendor_market_countries'
        ]);
    }
}
