<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FitgapTest extends TestCase
{
    use RefreshDatabase;

    public function testCanSetFirst5ColumnsInProject()
    {
        $project = factory(Project::class)->create();

        $project->fitgap5Columns = [
            [
                'Requirement Type' => 'yeeeeee',
                'Level 1' => 'hye',
                'Level 2' => 'hye',
                'Level 3' => 'hye',
                'Requirement' => 'hye',
            ]
        ];

        $project->save();

        $this->assertNotNull($project->fitgap5Columns);
        $this->assertIsArray($project->fitgap5Columns);

        $this->assertEquals('yeeeeee', $project->fitgap5Columns[0]['Requirement Type']);
    }

    public function testCanSetClientColumnsInProject()
    {
        $project = factory(Project::class)->create();

        $project->fitgapClientColumns = [
            [
                'Client' => 'Must',
                'Business Opportunity' => 'Yes',
            ]
        ];

        $project->save();

        $this->assertNotNull($project->fitgapClientColumns);
        $this->assertIsArray($project->fitgapClientColumns);

        $this->assertEquals('Must', $project->fitgapClientColumns[0]['Client']);
    }

    public function testCanSetVendorColumnsInVendorApplication()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' =>  [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ]
        ]);

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        // The observer should set the default values
        $this->assertNotNull($application->fitgapVendorColumns);
        $this->assertIsArray($application->fitgapVendorColumns);

        // Check that we can change them anyway
        $application->fitgapVendorColumns = [
            [
                'Vendor Response' => 'Project fully supports the functionality',
                'Comments' => 'Heeloooo',
            ]
        ];
        $application->save();

        $application->refresh();
        $this->assertNotNull($application->fitgapVendorColumns);
        $this->assertIsArray($application->fitgapVendorColumns);

        $this->assertEquals('Project fully supports the functionality', $application->fitgapVendorColumns[0]['Vendor Response']);
    }






    public function testCanGetClientFitgapJson()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ],
            'fitgapClientColumns' => [
                [
                    'Client' => 'Must',
                    'Business Opportunity' => 'Yes',
                ]
            ]
        ]);

        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();

        $response = $this->actingAs($accenture)
            ->get(route('fitgapClientJson', ['project' => $project]));

        $response->assertOk()
            ->assertExactJson([
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                    'Client' => 'Must',
                    'Business Opportunity' => 'Yes',
                ]
            ]);
    }

    public function testCanGetVendorFitgapJson()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ]
        ]);

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $application = $vendor->applyToProject($project);

        $application->fitgapVendorColumns = [
            [
                'Vendor Response' => 'responseee',
                'Comments' => 'this is a comnment',
            ]
        ];
        $application->save();


        $response = $this->actingAs($vendor)
            ->get(route('fitgapVendorJson', ['project' => $project, 'vendor' => $vendor]));

        $response->assertOk()
            ->assertExactJson([
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                    'Vendor Response' => 'responseee',
                    'Comments' => 'this is a comnment',
                ]
            ]);
    }

    public function testCanGetEvaluationFitgapJson()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ]
        ]);

        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $response = $this->actingAs($accenture)
            ->get(route('fitgapEvaluationJson', ['project' => $project, 'vendor' => $vendor]));

        $response->assertOk()
            ->assertExactJson([
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                    'Client' => '',
                    'Business Opportunity' => '',
                    'Vendor Response' => '',
                    'Comments' => ''
                ]
            ]);
    }






    public function testCanChangeClientFitgapInProject()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ],
                [
                    'Requirement Type' => 'asdf',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ],
            'fitgapClientColumns' => [
                [
                    'Client' => '',
                    'Business Opportunity' => '',
                ],
                [
                    'Client' => '',
                    'Business Opportunity' => '',
                ]
            ]
        ]);

        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();


        $response = $this->actingAs($accenture)
            ->post(route('fitgapClientJsonUpload', ['project' => $project]), [
                'data' => [
                    [
                        'Requirement Type' => 'yeeeeee',
                        'Level 1' => 'hye',
                        'Level 2' => 'hye',
                        'Level 3' => 'hye',
                        'Requirement' => 'hye',
                        'Client' => 'Must test string',
                        'Business Opportunity' => 'Yes yes yes',
                    ],
                    [
                        'Requirement Type' => 'asdf',
                        'Level 1' => 'hye',
                        'Level 2' => 'hye',
                        'Level 3' => 'hye',
                        'Requirement' => 'hye',
                        'Client' => 'Must test string',
                        'Business Opportunity' => 'no no no',
                    ]
                ]
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertEquals('Must test string', $project->fitgapClientColumns[0]['Client']);
        $this->assertEquals('Yes yes yes', $project->fitgapClientColumns[0]['Business Opportunity']);
        $this->assertEquals('no no no', $project->fitgapClientColumns[1]['Business Opportunity']);

    }

    public function testCanChangeVendorFitgapInVendorApplication()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'yeeeeee',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ]
            ]
        ]);
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
            ->post(route('fitgapVendorJsonUpload', ['vendor' => $vendor, 'project' => $project]), [
                'data' => [
                    [
                        'Requirement Type' => 'yeeeeee',
                        'Level 1' => 'hye',
                        'Level 2' => 'hye',
                        'Level 3' => 'hye',
                        'Requirement' => 'hye',
                        'Vendor Response' => 'Hello',
                        'Comments' => 'Bye',
                    ]
                ]
            ]);

        $response->assertOk();

        $application->refresh();
        $this->assertEquals('Hello', $application->fitgapVendorColumns[0]['Vendor Response']);
        $this->assertEquals('Bye', $application->fitgapVendorColumns[0]['Comments']);
    }

    // Fitgap autocalculates the score now
    public function testCanChangeFitgapEvaluationInVendorApplication()
    {
        // $project = factory(Project::class)->create([
        //     'fitgap5Columns' => [
        //         [
        //             'Requirement Type' => 'yeeeeee',
        //             'Level 1' => 'hye',
        //             'Level 2' => 'hye',
        //             'Level 3' => 'hye',
        //             'Requirement' => 'hye',
        //         ]
        //     ]
        // ]);
        // /** @var User $vendor */
        // $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        // $application = $vendor->applyToProject($project);

        // $response = $this->actingAs($vendor)
        //     ->post(route('fitgapEvaluationJsonUpload', ['vendor' => $vendor, 'project' => $project]), [
        //         'data' => [
        //             [
        //                 'Requirement Type' => 'yeeeeee',
        //                 'Level 1' => 'hye',
        //                 'Level 2' => 'hye',
        //                 'Level 3' => 'hye',
        //                 'Requirement' => 'hye',
        //                 'Vendor Response' => 'Hello',
        //                 'Comments' => 'Bye',
        //                 'Score' => 31
        //             ]
        //         ]
        //     ]);

        // $response->assertOk();

        // $application->refresh();
        // $this->assertEquals(31, $application->fitgapVendorScores[0]);
    }








    public function testCanGetClientFitgapIframe()
    {
        $project = factory(Project::class)->create();
        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();

        $response = $this->actingAs($accenture)
            ->get(route('fitgapClientIframe', ['project' => $project]));

        $response->assertOk()
            ->assertSee('Export document')
            ->assertSee('fitgapClientJson')
            ->assertDontSee('fitgapVendorJson')
            ->assertDontSee('fitgapEvaluationJson')
            ->assertSee($project->id);
    }

    public function testCanGetVendorFitgapIframe()
    {
        $project = factory(Project::class)->create();

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
            ->get(route('fitgapVendorIframe', ['vendor' => $vendor, 'project' => $project]));

        $response->assertOk()
            ->assertSee('Export document')
            ->assertDontSee('fitgapClientJson')
            ->assertSee('fitgapVendorJson')
            ->assertDontSee('fitgapEvaluationJson')
            ->assertSee($vendor->id)
            ->assertSee($project->id);
    }

    public function testCanGetEvaluationFitgapIframe()
    {
        $project = factory(Project::class)->create();

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
            ->get(route('fitgapEvaluationIframe', ['vendor' => $vendor, 'project' => $project]));

        $response->assertOk()
            ->assertSee('Export document')
            ->assertDontSee('fitgapClientJson')
            ->assertDontSee('fitgapVendorJson')
            ->assertSee('fitgapEvaluationJson')
            ->assertSee($vendor->id)
            ->assertSee($project->id);
    }





    public function testAddingMoreRowsToThe5ColsDoesntBreakTheClientGets()
    {
        $project = factory(Project::class)->create([
            'fitgap5Columns' => [
                [
                    'Requirement Type' => 'row 1',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                ],
                [
                    'Requirement Type' => 'row 2',
                    'Level 1' => 'asdf',
                    'Level 2' => 'xzcv',
                    'Level 3' => 'qwre',
                    'Requirement' => 'okk',
                ]
            ],
            'fitgapClientColumns' => [
                [
                    'Client' => 'Must',
                    'Business Opportunity' => 'Yes',
                ],
                [
                    'Client' => 'Must',
                    'Business Opportunity' => 'No',
                ]
            ]
        ]);


        $project->fitgap5Columns = [
            [
                'Requirement Type' => 'row 1',
                'Level 1' => 'hye',
                'Level 2' => 'hye',
                'Level 3' => 'hye',
                'Requirement' => 'hye',
            ],
            [
                'Requirement Type' => 'row 2',
                'Level 1' => 'asdf',
                'Level 2' => 'xzcv',
                'Level 3' => 'qwre',
                'Requirement' => 'okk',
            ],
            [
                'Requirement Type' => 'row 3',
                'Level 1' => 'asdf',
                'Level 2' => 'pljknm',
                'Level 3' => 'qwre',
                'Requirement' => 'bvgt',
            ]
        ];
        $project->save();


        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();

        $response = $this->actingAs($accenture)
            ->get(route('fitgapClientJson', ['project' => $project]));

        $response->assertOk()
            ->assertExactJson([
                [
                    'Requirement Type' => 'row 1',
                    'Level 1' => 'hye',
                    'Level 2' => 'hye',
                    'Level 3' => 'hye',
                    'Requirement' => 'hye',
                    'Client' => 'Must',
                    'Business Opportunity' => 'Yes',
                ],
                [
                    'Requirement Type' => 'row 2',
                    'Level 1' => 'asdf',
                    'Level 2' => 'xzcv',
                    'Level 3' => 'qwre',
                    'Requirement' => 'okk',
                    'Client' => 'Must',
                    'Business Opportunity' => 'No',
                ],
                [
                    'Requirement Type' => 'row 3',
                    'Level 1' => 'asdf',
                    'Level 2' => 'pljknm',
                    'Level 3' => 'qwre',
                    'Requirement' => 'bvgt',
                    'Client' => '',
                    'Business Opportunity' => '',
                ]
            ]);
    }
}
