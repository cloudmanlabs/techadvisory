<?php

namespace Tests\Feature\Views\Accenture;

use App\GeneralInfoQuestion;
use App\Practice;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectViewTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureProjectViewWithoutProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/view');

        $response->assertStatus(404);
    }

    public function testAccentureProjectViewWithProject()
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
            ->get('/accenture/project/view/' . $project->id);

        $response->assertStatus(200)
            ->assertSee('Project name')
            ->assertSee('praaacticeeeee')
            ->assertSee('SOme Clieneet nameee');
    }

    public function testGeneralInfoQuestionsWork()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/view/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }

    public function testSizingQuestionsWork()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/project/view/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }

    public function testSelectionCriteriaQuestionsWork()
    {
        $user = factory(User::class)->states('accenture')->create();
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
            ->get('/accenture/project/view/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            $assertion->assertSee('Page ' . $page . ' Question');
        }
    }
}
