<?php

use App\VendorProfileQuestion;
use Illuminate\Database\Seeder;

class VendorProfileQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Vendor segment',
            'type' => 'selectSingle',
            'presetOption' => 'custom',
            'options' => 'Megasuite, SCM suite, Specific solution',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorSegment',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Geographies with solution implementations',
            'type' => 'selectMultiple',
            'presetOption' => 'regions',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorRegions',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Industry Experience',
            'type' => 'selectSingle',
            'presetOption' => 'industryExperience',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorIndustry',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'SC Capability (Practice)',
            'type' => 'selectSingle',
            'presetOption' => 'practices',

            'fixed' => true,
            'fixedQuestionIdentifier' => 'vendorPractice',
        ]);



        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Vendor contact role',
            'type' => 'text',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Address',
            'type' => 'text',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Vendor contact phone',
            'type' => 'text',
            'placeholder' => '+000 000 000'
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Link to your website',
            'type' => 'text',
            'placeholder' => 'https://'
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Foundation year',
            'type' => 'text',
            'placeholder' => 'Enter year'
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Specify Senior Management team (name, title & years in the company)',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Company Vision',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'High-level development strategy',
            'type' => 'textarea',
        ]);

        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Headquarters',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Commercials Offices',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Services Team Offices',
            'type' => 'selectMultiple',
            'presetOption' => 'countries',
        ]);

        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Number of employees',
            'type' => 'selectSingle',
            'presetOption' => 'custom',
            'options' => '0-50, 50-500, 500-5.000, 5.000-30.000, +30.000',
            'placeholder' => 'Please select the range'
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Number of employees in R&D',
            'type' => 'number',
            'placeholder' => 'Enter number',
        ]);

        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Partnerships',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'general',
            'label' => 'Indicate if your company is Public or private',
            'type' => 'selectSingle',
            'presetOption' => 'custom',
            'options' => 'Public, Private',
            'placeholder' => 'Please select'
        ]);

        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Stock exchange and ticker symbol',
            'type' => 'text',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Describe ownership structure',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Month in which fiscal year ends',
            'type' => 'text',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'label' => 'Finance currency',
            'type' => 'selectSingle',
            'presetOption' => 'currencies',
            'placeholder' => 'Please select'
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Indicate YTD Results 2020 - Revenue, Profit, R&D Expenses',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Indicate 2019 Results - Revenue, Profit, R&D Expenses',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Indicate 2018 Results - Revenue, Profit, R&D Expenses',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Current Balance Sheet Information',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Cash and cash equivalents',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Other current assets',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Current liabilities',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Quick ratio (current assets - current liabilities)',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'economic',
            'label' => 'Total amount of debt',
            'type' => 'textarea',
        ]);


        factory(VendorProfileQuestion::class)->create([
            'page' => 'legal',
            'label' => 'Any litigation pending?',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'legal',
            'label' => 'Number of lawsuits in history of company?',
            'type' => 'textarea',
        ]);
        factory(VendorProfileQuestion::class)->create([
            'page' => 'legal',
            'label' => 'Are you currently in any discussions about being acquired?',
            'type' => 'textarea',
        ]);
    }
}
