<?php

namespace Tests\Feature\Views\Client\ProjectBenchmark;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testClientProjectBenchmarksWithoutProject()
    {
        $user = factory(User::class)->states('client')->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/project/benchmark');

        $response->assertStatus(404);
    }

    public function testClientProjectBenchmarksWithProject()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states('client')->create([
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
            ->get('/client/project/benchmark/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testClientProjectBenchmarksExperienceWithNotOwnedProject()
    {
        $user = factory(User::class)->states('client')->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $owner = factory(User::class)->states('client')->create();
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $owner->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/client/project/benchmark/' . $project->id);

        $response->assertStatus(404);
    }
}
