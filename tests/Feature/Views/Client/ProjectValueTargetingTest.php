<?php

namespace Tests\Feature\Views\Client;

use App\User;
use App\Practice;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectValueTargetingTest extends TestCase
{
    use RefreshDatabase;

    public function testClientProjectValueTargetingWithoutProject()
    {
        $user = factory(User::class)->states('client')->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/project/valueTargeting');

        $response->assertStatus(404);
    }

    private function createProject(array $data)
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states('client')->create([
            'name' => 'SOme Clieneet nameee'
        ]);
        $project = factory(Project::class)->create(array_merge([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ], $data));

        return [$client, $practice, $project];
    }

    public function testClientProjectValueTargetingWithProject()
    {
        list($client, $practice, $project) = $this->createProject([
            'hasValueTargeting' => true,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/valueTargeting/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testCantAccessValueTargetingIfValueTargetingIsFalse()
    {
        list($client, $practice, $project) = $this->createProject([
            'hasValueTargeting' => false,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/valueTargeting/' . $project->id);

        $response->assertStatus(404);
    }

    public function testClientProjectValueTargetingWithNotOwnedProject()
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
            ->get('/client/project/valueTargeting/' . $project->id);

        $response->assertStatus(404);
    }
}
