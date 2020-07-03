<?php

use App\Practice;
use App\SizingQuestion;
use Illuminate\Database\Seeder;

class SizingQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Transport questions
        $transportPractice = Practice::where('name', 'Transport')->first();
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Maximum number of concurrent users',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Number of named users',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Annual number shipments',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Average number of shipments per month valley season',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Average number of shipments per month peak season',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);

        $planningPractice = Practice::where('name', 'Planning')->first();
        factory(SizingQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Countries',
            'required' => false,
            'presetOption' => 'countries',
            'practice_id' => $planningPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => 'Transport Spend',
            'required' => false,
            'practice_id' => $planningPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Suppliers',
            'required' => false,
            'practice_id' => $planningPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Plants',
            'required' => false,
            'practice_id' => $planningPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Warehouses',
            'required' => false,
            'practice_id' => $planningPractice->id
        ]);

        $manufacturingPractice = Practice::where('name', 'Manufacturing')->first();
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Direct customers',
            'required' => false,
            'practice_id' => $manufacturingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Final Clients',
            'required' => false,
            'practice_id' => $manufacturingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '# Carriers',
            'required' => false,
            'practice_id' => $manufacturingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Complex movements (different than OW)',
            'required' => false,
            'practice_id' => $manufacturingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% own fleet',
            'required' => false,
            'practice_id' => $manufacturingPractice->id
        ]);

        $wharehousingPractice = Practice::where('name', 'Warehousing')->first();
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% dedicated fleet',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% contracted fleet',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Road movements',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Maritime movements',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Air movements',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Rail movements',
            'required' => false,
            'practice_id' => $wharehousingPractice->id
        ]);

        $sourcingPractice = Practice::where('name', 'Sourcing')->first();
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Fluvial movements',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Intermodal movements',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% International',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Domestic',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Inbound',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% Last mile',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'number',
            'label' => '% FTL vs parcial',
            'required' => false,
            'practice_id' => $sourcingPractice->id
        ]);
    }
}
