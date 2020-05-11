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

    public function testCanChangeFitgapInVendorApplication()
    {
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
                         ->post(route('fitgapVendorJsonUpload', ['vendor' => $vendor, 'project' => $project]), [
                            'data' => [
                                'hello' => 'hey'
                            ]
                         ]);

        $response->assertOk();

        $application->refresh();
        $this->assertNotNull($application->fitgapData);
        $this->assertIsArray($application->fitgapData);
    }

    public function testCanGetFitgapJsonFromRoute()
    {
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application->fitgapData = [
            'hey' => 'hi'
        ];
        $application->save();

        $response = $this->actingAs($vendor)
            ->get(route('fitgapVendorJson', ['vendor' => $vendor, 'project' => $project]));

        $response->assertOk()
            ->assertJson([
                'hey' => 'hi',
            ]);
    }
}
