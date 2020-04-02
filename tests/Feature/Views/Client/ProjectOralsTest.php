<?php

namespace Tests\Feature\Views\Client;

use App\User;
use App\Practice;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectOralsTest extends TestCase
{
    use RefreshDatabase;

    public function testClientProjectOralsWithoutProject()
    {
        $user = factory(User::class)->states('client')->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/project/orals');

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

    public function testClientProjectOralsWithProject()
    {
        list($client, $practice, $project) = $this->createProject([
            'hasOrals' => true,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/orals/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testCantAccessOralsIfOralsIsFalse()
    {
        list($client, $practice, $project) = $this->createProject([
            'hasOrals' => false,
        ]);

        $response = $this
            ->actingAs($client)
            ->get('/client/project/orals/' . $project->id);

        $response->assertStatus(404);
    }

    public function testClientProjectOralsWithNotOwnedProject()
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
            ->get('/client/project/orals/' . $project->id);

        $response->assertStatus(404);
    }
}