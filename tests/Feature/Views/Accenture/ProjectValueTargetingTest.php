<?php

namespace Tests\Feature\Views\Accenture;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectValueTargetingTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureProjectValueTargetingWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/valueTargeting');

        $response->assertStatus(404);
    }

    private function createProject(array $data)
    {
        $user = factory(User::class)->states('accenture')->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Clieneet nameee'
        ]);
        $project = factory(Project::class)->create(array_merge([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ], $data));

        return [$user, $practice, $project];
    }

    public function testAccentureProjectValueTargetingWithProject()
    {
        list($user, $practice, $project) = $this->createProject([
            'hasValueTargeting' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/valueTargeting/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee')
            ->assertSee('SOme Clieneet nameee');
    }

    public function testCantAccessValueTargetingIfValueTargetingIsFalse()
    {
        list($user, $practice, $project) = $this->createProject([
            'hasValueTargeting' => false,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/valueTargeting/' . $project->id);

        $response->assertStatus(404);
    }
}
