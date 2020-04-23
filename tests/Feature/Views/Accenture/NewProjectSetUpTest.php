<?php

namespace Tests\Feature\Views\Accenture;

use App\Project;
use App\SelectionCriteriaQuestion;
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
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $pages = array_keys(SelectionCriteriaQuestion::pagesSelect);

        foreach ($pages as $key => $page) {
            factory(SelectionCriteriaQuestion::class)->create([
                'page' => 'fitgap',
                'label' => 'Page ' . $page . ' Question',
                'type' => 'text',
            ]);
        }

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/newProjectSetUp/' . $project->id);

        $assertion = $response->assertStatus(200);

        foreach ($pages as $key => $page) {
            $assertion->assertSee('Page ' . $page . ' Question');
        }
    }
}
