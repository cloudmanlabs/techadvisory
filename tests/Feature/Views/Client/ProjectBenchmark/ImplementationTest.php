<?php

namespace Tests\Feature\Views\Client\ProjectBenchmark;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImplementationTest extends TestCase
{
    use RefreshDatabase;

    public function testClientProjectBenchmarksImplementationWithoutProject()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/project/benchmark/implementation');

        $response->assertStatus(404);
    }

    public function testClientProjectBenchmarksImplementationWithProject()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Clieneet nameee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/benchmark/implementation/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testClientProjectBenchmarksExperienceWithNotOwnedProject()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $owner = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $owner->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/client/project/benchmark/implementation/' . $project->id);

        $response->assertStatus(404);
    }
}
