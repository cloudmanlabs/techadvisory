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
    }
}
