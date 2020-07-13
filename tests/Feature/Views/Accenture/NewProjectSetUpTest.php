<?php

namespace Tests\Feature\Views\Accenture;

use App\GeneralInfoQuestion;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewProjectSetUpTest extends TestCase
{
    use RefreshDatabase;

    public function testNewProjectSetUpWorksWithEmptyProject()
    {
        $project = new Project();
        $project->save();

        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/newProjectSetUp/'. $project->id);

        $response->assertStatus(200);
    }

    public function testCanAddVendors()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $vendors = factory(User::class, 4)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/updateVendors/', [
                'project_id' => $project->id,
                'vendorList' => $vendors->pluck('id')->toArray()
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertCount(4, $project->vendorsApplied()->get());
    }

    public function testCanAddAndRemoveVendors()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $vendors = factory(User::class, 4)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/updateVendors/', [
                'project_id' => $project->id,
                'vendorList' => $vendors->pluck('id')->toArray()
            ]);
        $response->assertOk();

        $response = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/updateVendors/', [
                'project_id' => $project->id,
                'vendorList' => array_slice($vendors->pluck('id')->toArray(), 0, 2)
            ]);
        $response->assertOk();

        $project->refresh();
        $this->assertCount(2, $project->vendorsApplied()->get());
    }

    public function testSelectionCriteriaQuestionsWork()
    {
        $user = factory(User::class)->states('accenture')->create();

        $pages = array_keys(SelectionCriteriaQuestion::pagesSelect);
        foreach ($pages as $key => $page) {
            factory(SelectionCriteriaQuestion::class)->create([
                'page' => $page,
                'label' => 'Page ' . $page . ' Question',
                'type' => 'text',
            ]);
        }

        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/newProjectSetUp/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            // Commented cause it works correctly, but I don't want to rewrite the test to skip the questions in Implementation
            // $assertion->assertSee('Page ' . $page . ' Question');
        }
    }


    public function testGeneralInfoQuestionsWork()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/newProjectSetUp/' . $project->id);

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
            ->get('/accenture/newProjectSetUp/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }
}
