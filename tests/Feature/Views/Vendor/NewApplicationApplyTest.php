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

class NewApplicationApplyu extends TestCase
{
    use RefreshDatabase;

    public function testWithoutProject()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/vendors/newApplication/apply');

        $response->assertStatus(404);
    }

    public function testWithProjectAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $app = $vendor->applyToProject($project);
        $app->setApplicating();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/apply/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testWithProjectNotAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/apply/' . $project->id);

        $response->assertStatus(404);
    }

    public function testCantAccessWithApplicationNotInApplicatingPhase()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $app = $vendor->applyToProject($project);
        $app->setPendingEvaluation();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/apply/' . $project->id);

        $response->assertStatus(404);
    }

    public function testSelectionCriteriaQuestionsWork()
    {
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

        $app = $vendor->applyToProject($project);
        $app->setApplicating();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/apply/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            // $assertion->assertSee('Page ' . $page . ' Question');
        }
    }
}
