<?php

namespace Tests\Feature\Views\Vendor;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $response = $this
            ->actingAs($user)
            ->get('/vendors/home');

        $response->assertStatus(200);
    }

    public function testCanNotAccessIfVendorHasNotFinishedSetUp()
    {
        $user = factory(User::class)->states('vendor')->create();
        $response = $this
            ->actingAs($user)
            ->get('/vendors/home');

        $response->assertStatus(404);
    }

    public function testShowsListOfInvitedProjects()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/home');

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testShowsListOfStartedProjects()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setApplicating();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/home');

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testShowsListOfSubmittedProjects()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setSubmitted();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/home');

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testShowsListOfRejectedProjects()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setRejected();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/home');

        $response->assertStatus(200)
            ->assertSee($project->name);
    }
}
