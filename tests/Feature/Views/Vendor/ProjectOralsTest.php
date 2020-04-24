<?php

namespace Tests\Feature\Views\Vendor;

use App\User;
use App\Practice;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectOralsTest extends TestCase
{
    use RefreshDatabase;

    public function testWithoutProject()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/vendors/newApplication/orals');

        $response->assertStatus(404);
    }



    private function createProject(array $data)
    {
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
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        return [$client, $practice, $project, $vendor];
    }

    public function testClientProjectOralsWithProject()
    {
        list($client, $practice, $project, $vendor) = $this->createProject([
            'hasOrals' => true,
        ]);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/orals/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee');
    }

    public function testCantAccessOralsIfOralsIsFalse()
    {
        list($client, $practice, $project, $vendor) = $this->createProject([
            'hasOrals' => false,
        ]);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/orals/' . $project->id);

        $response->assertStatus(404);
    }

    public function testWithNotAppliedToProject()
    {
        $owner = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $owner->id,
        ]);

        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/orals/' . $project->id);

        $response->assertStatus(404);
    }
}
