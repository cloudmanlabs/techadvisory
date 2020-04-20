<?php

use App\VendorSolutionQuestion;
use Illuminate\Database\Seeder;

class VendorSolutionQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Vendor solution contact email',
            'type' => 'text',
            'placeholder' => 'Enter email'
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Vendor solution contact role',
            'type' => 'text',
            'placeholder' => 'Enter role'
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Vendor solution contact phone',
            'type' => 'text',
            'placeholder' => 'Enter phone'
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Provide high-level description of your solution and vision',
            'type' => 'textarea',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Describe core modules of your solution and third party applications that complement your offering',
            'type' => 'textarea',
        ]);

        factory(VendorSolutionQuestion::class)->create([
            'label' => 'SC Capabilities',
            'type' => 'selectMultiple',
            'presetOption' => 'practices',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Integration method',
            'type' => 'selectMultiple',
            'presetOption' => 'custom',
            'options' => 'EDI, API, Web Services, Others'
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Integration method',
            'type' => 'selectMultiple',
            'presetOption' => 'capabilities',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Transport flows',
            'type' => 'selectMultiple',
            'presetOption' => 'transportFlows',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Transport modes',
            'type' => 'selectMultiple',
            'presetOption' => 'transportModes',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Transport types',
            'type' => 'selectMultiple',
            'presetOption' => 'transportTypes',
        ]);
        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Digital Enablers',
            'type' => 'selectMultiple',
            'presetOption' => 'digitalEnablers',
        ]);

        factory(VendorSolutionQuestion::class)->create([
            'label' => 'Link to your website',
            'type' => 'text',
            'placeholder' => 'https://...'
        ]);
    }
}
