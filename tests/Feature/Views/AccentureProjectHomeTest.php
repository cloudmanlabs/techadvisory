<?php

namespace Tests\Feature\Views;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccentureProjectHomeTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureProjectViewWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home');

        $response->assertStatus(404);
    }

    public function testAccentureProjectViewWithProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states('client')->create([
            'name' => 'SOme Client nameee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
                ->assertSee('Project name');
    }
}
