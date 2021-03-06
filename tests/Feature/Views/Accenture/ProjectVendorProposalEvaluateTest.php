<?php

namespace Tests\Feature\evaluates\Accenture;

use App\GeneralInfoQuestion;
use App\Practice;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectVendorProposalEvaluate extends TestCase
{
    use RefreshDatabase;

    public function testWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/vendorProposal/evaluate');

        $response->assertStatus(404);
    }

    public function testWithProjectAppliedTo()
    {
        $user = factory(User::class)->states('accenture')->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();
        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/vendorProposal/evaluate/' . $project->id . '/'. $vendor->id);

        $response->assertStatus(200)
            ->assertSee($project->name)
            ->assertSee($vendor->name);
    }

    public function testWithProjectNotAppliedTo()
    {
        $user = factory(User::class)->states('accenture')->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/vendorProposal/evaluate/' . $project->id . '/' . $vendor->id);

        $response->assertStatus(404);
    }

    public function testSelectionCriteriaQuestionsWork()
    {
        $user = factory(User::class)->states('accenture')->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $pages = collect(array_keys(SelectionCriteriaQuestion::pagesSelect))
            ->filter(function($page){
                return !in_array($page, [
                    'fitgap',
                    'implementation_implementation',
                    'implementation_run',
                ]);
            });

        foreach ($pages as $key => $page) {
            factory(SelectionCriteriaQuestion::class)->create([
                'page' => $page,
                'label' => 'Page ' . $page . ' Question',
                'type' => 'text',
            ]);
        }

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/vendorProposal/evaluate/' . $project->id . '/' . $vendor->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            // $assertion->assertSee('Page ' . $page . ' Question');
        }
    }

    public function testCanSubmitEvaluationWithPost()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);
        $application->setPendingEvaluation();

        $response = $this
            ->actingAs($user)
            ->post('/accenture/project/submitEvaluation/' . $project->id . '/' . $vendor->id);

        $response->assertRedirect('/accenture/project/home/' . $project->id);

        $application->refresh();
        $this->assertEquals('evaluated', $application->phase);
    }
}
