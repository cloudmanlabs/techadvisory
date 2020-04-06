<?php

namespace Tests\Feature;

use App\Folder;
use App\Practice;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateProject()
    {
        $this->assertCount(0, Project::all());

        factory(Practice::class)->create();

        $project = new Project([
            'name' => 'New Project',
            'hasOrals' => false,
            'hasValueTargeting' => false,

            'progressSetUp' => 20,
            'progressValue' => 10,
            'progressResponse' => 0,
            'progressAnalytics' => 0,
            'progressConclusions' => 0,

            'currentPhase' => 'open',

            'deadline' => Carbon::now()
                                ->addMonth()
                                ->addWeek()
                                ->toDateTimeString(),

            'practice_id' => 1,
            'client_id' => 1,
        ]);
        $project->save();

        $this->assertCount(1, Project::all());
    }

    public function testProjectDefaultPhaseIsPreparation()
    {
        $this->assertCount(0, Project::all());

        factory(Practice::class)->create();

        $project = new Project([
            'name' => 'New Project',
            'hasOrals' => false,
            'hasValueTargeting' => false,

            'deadline' => Carbon::now()
                ->addMonth()
                ->addWeek()
                ->toDateTimeString(),

            'practice_id' => 1,
            'client_id' => 1,
        ]);
        $project->save();

        $this->assertCount(1, Project::preparationProjects()->get());
        $this->assertCount(0, Project::openProjects()->get());
        $this->assertCount(0, Project::oldProjects()->get());
    }

    public function testCanAddFoldersToProject()
    {
        $folder = Folder::createNewRandomFolder();
        $folder1 = Folder::createNewRandomFolder();
        $folder2 = Folder::createNewRandomFolder();
        $folder3 = Folder::createNewRandomFolder();

        $project = factory(Project::class)->create();

        $this->assertNull($project->conclusionsFolder);
        $this->assertNull($project->selectedValueLeversFolder);
        $this->assertNull($project->businessOpportunityFolder);
        $this->assertNull($project->vtConclusionsFolder);

        $project->conclusionsFolder = $folder;
        $project->selectedValueLeversFolder = $folder1;
        $project->businessOpportunityFolder = $folder2;
        $project->vtConclusionsFolder = $folder3;

        $this->assertNotNull($project->conclusionsFolder);
        $this->assertNotNull($project->selectedValueLeversFolder);
        $this->assertNotNull($project->businessOpportunityFolder);
        $this->assertNotNull($project->vtConclusionsFolder);
    }

    public function testCanAddPracticesToProject()
    {
        $practice = factory(Practice::class)->create();

        $project = factory(Project::class)->make([
            'practice_id' => null
        ]);

        $this->assertNull($project->practice);

        $project->practice()->associate($practice);
        $project->save();

        $this->assertNotNull($project->practice);
    }

    public function testCanAddClientToProject()
    {
        $client = factory(User::class)->states('client')->create();

        $project = factory(Project::class)->make([
            'client_id' => null
        ]);

        $this->assertNull($project->client);

        $project->client()->associate($client);
        $project->save();

        $this->assertNotNull($project->client);
    }

    public function testCanCreateProjectFromRoute()
    {
        $this->assertCount(0, Project::all());

        $user = factory(User::class)->states('accenture')->create();
        $request = $this
                        ->actingAs($user)
                        ->post('accenture/createProject');

        $this->assertCount(1, Project::all());

        $project = Project::first();

        $request->assertStatus(302)
                ->assertRedirect(route('accenture.newProjectSetUp', ['project'=> $project]));
    }

    public function testAccentureCanEditProjectName()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create([
            'name' => 'oldName'
        ]);

        $request = $this
                        ->actingAs($user)
                        ->post('/accenture/newProjectSetUp/changeProjectName',[
                            'project_id' => $project->id,
                            'newName' => 'new'
                        ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('new', $project->name);
    }

    public function testClientAndVendorCanNotEditProjectName()
    {
        $client = factory(User::class)->states('client')->create();
        $vendor = factory(User::class)->states('vendor')->create();
        $project = factory(Project::class)->create([
            'name' => 'oldName'
        ]);

        $request = $this
            ->actingAs($vendor)
            ->post('/accenture/newProjectSetUp/changeProjectName', [
                'project_id' => $project->id,
                'newName' => 'new'
            ]);

        $request->assertStatus(302);

        $request = $this
            ->actingAs($client)
            ->post('/accenture/newProjectSetUp/changeProjectName', [
                'project_id' => $project->id,
                'newName' => 'new'
            ]);

        $request->assertStatus(302);

        $project->refresh();
        $this->assertEquals('oldName', $project->name);
    }

    public function testCanChangeClientInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        factory(User::class, 5)->states('client')->create();

        $project = factory(Project::class)->create([
            'client_id' => 1,
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeProjectClient', [
                'project_id' => $project->id,
                'client_id' => 2
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals(2, $project->client_id);
    }

    public function testCanChangeHasValueTargetingInProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create([
            'hasValueTargeting' => false
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeProjectHasValueTargeting', [
                'project_id' => $project->id,
                'value' => 'yes'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals(1, $project->hasValueTargeting);
    }

    public function testCanChangeIsBindingInProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create([
            'isBinding' => false
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeProjectIsBinding', [
                'project_id' => $project->id,
                'value' => 'yes'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals(1, $project->isBinding);
    }
}
