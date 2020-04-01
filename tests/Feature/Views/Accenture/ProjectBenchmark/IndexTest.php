<?php

namespace Tests\Feature\Views\Accenture\ProjectBenchmark;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureProjectBenchmarksWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/benchmark');

        $response->assertStatus(404);
    }

    public function testAccentureProjectBenchmarksWithProject()
    {
        $user = factory(User::class)->states('accenture')->create();
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
            ->actingAs($user)
            ->get('/accenture/project/benchmark/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee')
            ->assertSee('SOme Clieneet nameee');
    }
}
