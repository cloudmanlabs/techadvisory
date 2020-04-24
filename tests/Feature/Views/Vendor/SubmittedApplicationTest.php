<?php

namespace Tests\Feature\Views\Vendor;

use App\GeneralInfoQuestion;
use App\Practice;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmittedApplicationApplyu extends TestCase
{
    use RefreshDatabase;

    public function testWithoutProject()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/vendors/submittedApplication');

        $response->assertStatus(404);
    }

    public function testWithProjectAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/submittedApplication/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testWithProjectNotAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/submittedApplication/' . $project->id);

        $response->assertStatus(404);
    }

    public function testCantAccessWithApplicationInApplicatingPhase()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $app = $vendor->applyToProject($project);
        $app->setApplicating();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/submittedApplication/' . $project->id);

        $response->assertStatus(404);
    }

    public function testSelectionCriteriaQuestionsWork()
    {
        $this->withoutExceptionHandling();

        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $pages = array_keys(SelectionCriteriaQuestion::pagesSelect);

        foreach ($pages as $key => $page) {
            factory(SelectionCriteriaQuestion::class)->create([
                'page' => $page,
                'label' => 'Page ' . $page . ' Question',
                'type' => 'text',
            ]);
        }

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/submittedApplication/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            $assertion->assertSee('Page ' . $page . ' Question');
        }
    }
}
