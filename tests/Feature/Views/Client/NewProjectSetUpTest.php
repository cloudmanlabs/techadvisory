<?php

namespace Tests\Feature\Views\Client;

use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\SizingQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewProjectSetUpTest extends TestCase
{
    use RefreshDatabase;

    public function testNewProjectSetUpWorksWithEmptyProject()
    {
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = new Project([
            'client_id' => $client->id
        ]);
        $project->save();

        $response = $this
            ->actingAs($client)
            ->get('/client/newProjectSetUp/'. $project->id);

        $response->assertStatus(200);
    }

    public function testSelectionCriteriaQuestionsWork()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

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
            ->actingAs($user)
            ->get('/client/newProjectSetUp/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            $assertion->assertSee('Page ' . $page . ' Question');
        }
    }

    public function testSizingQuestionsWork()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/client/newProjectSetUp/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }
}
