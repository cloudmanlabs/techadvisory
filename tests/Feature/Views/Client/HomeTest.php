<?php

namespace Tests\Feature\Views\Client;

use App\Project;
use App\Practice;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $response = $this
                    ->actingAs($user)
                    ->get('/client/home');

        $response->assertStatus(200);
    }

    public function testPreparationPhaseProjects()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,

            'step3SubmittedAccenture' => true
        ]);

        $response = $this->actingAs($client)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaactice');
    }

    public function testDoesntShowPreparationProjectsNotSubmittedPage3ByAccenture()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaacticeeeeeee'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        $project = factory(Project::class)->create([
            'name' => 'prroooooooject',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,

            'step3SubmittedAccenture' => false
        ]);

        $response = $this->actingAs($client)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertDontSee('prroooooooject')
            ->assertDontSee('praaactice');
    }

    public function testPreparationProjectFromAnotherClientDoesntShow()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'preparation',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertDontSee('Project name')
            ->assertDontSee('praaactice');
    }

    public function testOpenPhaseProjects()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'open',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($client)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaactice');
    }

    public function testOpenProjectFromAnotherClientDoesntShow()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'open',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertDontSee('Project name')
            ->assertDontSee('praaactice');
    }

    public function testOldPhaseProjects()
    {
        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'old',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($client)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaactice');
    }

    public function testOldProjectFromAnotherClientDoesntShow()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $practice = factory(Practice::class)->create([
            'name' => 'praaactice'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create([
            'name' => 'SOme Client company name*ee'
        ]);
        factory(Project::class)->create([
            'name' => 'Project name',
            'currentPhase' => 'open',

            'practice_id' => $practice->id,
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(200)
            ->assertDontSee('Project name')
            ->assertDontSee('praaactice');
    }

    public function testCanNotAccessIfClientHasNotFinishedSetUp()
    {
        $user = factory(User::class)->states('client')->create();
        $response = $this
            ->actingAs($user)
            ->get('/client/home');

        $response->assertStatus(404);
    }
}
