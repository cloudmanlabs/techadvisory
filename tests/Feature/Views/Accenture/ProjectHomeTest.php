<?php

namespace Tests\Feature\Views\Accenture;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectHomeTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureProjectHomeWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home');

        $response->assertStatus(404);
    }

    public function testAccentureProjectHomeWithProject()
    {
        $user = factory(User::class)->states('accenture')->create();
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
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
                ->assertSee('Project name')
                ->assertSee('praaacticeeeee')
                ->assertSee('SOme Clieneet nameee');
    }

    public function testShowsInvitedProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/'.$project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testShowsApplicatingProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setApplicating();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }

    public function testShowsPendingEvaluationProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setPendingEvaluation();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }

    public function testShowsEvaluatedProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setEvaluated();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }

    public function testShowsSubmittedProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setSubmitted();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }

    public function testShowsDisqualifiedProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setDisqualified();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }

    public function testShowsRejectedProjects()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setRejected();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/home/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($vendor->name);
    }
}
