<?php

namespace Tests\Feature\Views\Client;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectHomeTest extends TestCase
{
    use RefreshDatabase;


    public function testClientProjectHomeWithoutProject()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/project/home');

        $response->assertStatus(404);
    }

    public function testClientProjectHomeWithProject()
    {
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testClientProjectHomeWithNotOwnedProject()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/client/project/home/' . $project->id);

        $response->assertStatus(404);
    }

    public function testShowsStartedVendors()
    {
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $application = $vendor->applyToProject($project);
        $application->setApplicating();

        $response = $this
            ->actingAs($client)
            ->get('/client/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testShowsSubmittedVendors()
    {
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $application = $vendor->applyToProject($project);
        $application->setSubmitted();

        $response = $this
            ->actingAs($client)
            ->get('/client/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }
}
