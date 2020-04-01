<?php

namespace Tests\Feature\Views\Accenture;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testPreparationPhaseProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states('client')->create([
            'name' => 'SOme Client nameee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200)
                ->assertSee('Project name')
                ->assertSee('praaactice')
                ->assertSee('SOme Client nameee');
    }

    public function testOpenPhaseProjects()
    {
        $user = factory(User::class)->states('accenture')->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states('client')->create([
            'name' => 'SOme Client nameee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'open',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaactice')
            ->assertSee('SOme Client nameee');
    }

    public function testOldPhaseProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states('client')->create([
            'name' => 'SOme Client nameee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'old',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaactice')
            ->assertSee('SOme Client nameee');
    }

    public function testPracticeFilterGetsCorrectValues()
    {
        $user = factory(User::class)->states('accenture')->create();
        $practices = factory(Practice::class, 3)->create();

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200)
            ->assertSeeInOrder( // We have to see each practice in order three times
                array_merge(
                    $practices->pluck('name')->toArray(),
                    $practices->pluck('name')->toArray(),
                    $practices->pluck('name')->toArray(),
                )
            );
    }

    public function testClientFilterGetsCorrectValues()
    {
        $user = factory(User::class)->states('accenture')->create();
        $clients = factory(User::class, 3)->states('client')->create();

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200)
            ->assertSeeInOrder( // We have to see each practice in order three times
                array_merge(
                    $clients->pluck('name')->toArray(),
                    $clients->pluck('name')->toArray(),
                    $clients->pluck('name')->toArray(),
                )
            );
    }
}
