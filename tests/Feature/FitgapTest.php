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

    public function testCanChangeVendorFitgapInVendorApplication()
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

    public function testCanGetVendorFitgapJsonFromRoute()
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

    public function testCanGetVendorFitgapIframe()
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
            ->get(route('fitgapVendorIframe', ['vendor' => $vendor, 'project' => $project]));

        $response->assertOk()
                    ->assertSee('Export document as CSV')
                    ->assertDontSee('fitgapMainJson')
                    ->assertSee('fitgapVendorJson')
                    ->assertSee($vendor->id)
                    ->assertSee($project->id);
    }


    public function testCanChangeMainFitgapInProject()
    {
        $this->withoutExceptionHandling();

        /** @var Project $project */
        $project = factory(Project::class)->create();
        /** @var User $accenture */
        $accenture = factory(User::class)->states(['accenture'])->create();

        $response = $this->actingAs($accenture)
            ->post(route('fitgapMainJsonUpload', ['project' => $project]), [
                'data' => [
                    'hello' => 'hey'
                ]
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertNotNull($project->fitgapData);
        $this->assertIsArray($project->fitgapData);
    }

    public function testCanGetMainFitgapJsonFromRoute()
    {
        $project = factory(Project::class)->create();
        $accenture = factory(User::class)->states(['accenture'])->create();

        $project->fitgapData = [
            'hey' => 'hi'
        ];
        $project->save();

        $response = $this->actingAs($accenture)
            ->get(route('fitgapMainJson', ['project' => $project]));

        $response->assertOk()
            ->assertJson([
                'hey' => 'hi',
            ]);
    }

    public function testCanGetMainFitgapIframe()
    {
        $project = factory(Project::class)->create();
        $accenture = factory(User::class)->states(['accenture'])->create();

        $project->fitgapData = [
            'hey' => 'hi'
        ];
        $project->save();

        $response = $this->actingAs($accenture)
            ->get(route('fitgapMainIframe', ['project' => $project]));

        $response->assertOk()
            ->assertSee('Export document as CSV')
            ->assertSee('fitgapMainJson')
            ->assertDontSee('fitgapVendorJson')
            ->assertSee($project->id);
    }
}
