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
            'type' => 'textarea',
            'label' => 'Short Description',
            'required' => true,
            'practice_id' => $transportPractice->id
        ]);
        factory(SizingQuestion::class)->create([
            'type' => 'text',
            'label' => 'Client contact e-mail',
            'placeholder' => 'Client contact e-mail',
            'required' => false,
            'practice_id' => $transportPractice->id
        ]);
    }
}
