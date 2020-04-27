<?php

namespace Tests\Feature;

use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use Carbon\Carbon;
use Guimcaballero\LaravelFolders\Models\Folder;
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

    public function testCanAddSubpracticesToProject()
    {
        $subpractice = factory(Subpractice::class)->create();

        $project = factory(Project::class)->create();

        $this->assertCount(0, $project->subpractices);

        $project->subpractices()->attach($subpractice);

        $project->refresh();
        $this->assertCount(1, $project->subpractices);
    }

    public function testCanAddClientToProject()
    {
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

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
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
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

        factory(User::class, 5)->states(['client', 'finishedSetup'])->create();

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

    public function testCanChangePracticeInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $practice1 = factory(Practice::class)->create();
        $practice2 = factory(Practice::class)->create();
        $project = factory(Project::class)->create([
            'practice_id' => $practice1->id
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changePractice', [
                'project_id' => $project->id,
                'practice_id' => $practice2->id
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals($practice2->id, $project->practice->id);
    }

    public function testCanChangeSubpracticeInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $subpractice1 = factory(Subpractice::class)->create();
        $subpractice2 = factory(Subpractice::class)->create();
        $subpractice3 = factory(Subpractice::class)->create();
        $project = factory(Project::class)->create();

        $project->subpractices()->attach($subpractice1);
        $this->assertCount(1, $project->subpractices);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeSubpractice', [
                'project_id' => $project->id,
                'subpractices' => [$subpractice2->id, $subpractice3->id],
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertCount(2, $project->subpractices);
    }

    public function testCanSetStep3SubmittedForAccenture()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $this->assertFalse(boolval($project->step3SubmittedAccenture));

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/setStep3Submitted', [
                'project_id' => $project->id,
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue($project->step3SubmittedAccenture);
    }

    public function testCanSetStep4SubmittedForAccenture()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $this->assertFalse(boolval($project->step4SubmittedAccenture));

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/setStep4Submitted', [
                'project_id' => $project->id,
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue($project->step4SubmittedAccenture);
    }

    public function testCanSetStep3SubmittedForClient()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $this->assertFalse(boolval($project->step3SubmittedClient));

        $request = $this
            ->actingAs($user)
            ->post('/client/newProjectSetUp/setStep3Submitted', [
                'project_id' => $project->id,
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue($project->step3SubmittedClient);
    }

    public function testCanSetStep4SubmittedForClient()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $this->assertFalse(boolval($project->step4SubmittedClient));

        $request = $this
            ->actingAs($user)
            ->post('/client/newProjectSetUp/setStep4Submitted', [
                'project_id' => $project->id,
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue($project->step4SubmittedClient);
    }

    public function testAccentureCanPublishProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $this->assertEquals('preparation', $project->currentPhase);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/publishProject', [
                'project_id' => $project->id,
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('open', $project->currentPhase);
    }



    public function testAccentureCanUpdateScoringValues()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        $this->assertEquals([0, 0, 0, 0, 0], $project->scoringValues);

        $response = $this->actingAs($user)
                    ->post('/accenture/newProjectSetUp/updateScoringValues', [
                        'project_id' => $project->id,
                        'values' => [0, 1, 2, 3, 4]
                    ]);

        $response->assertOk();

        $project->refresh();
        $this->assertEquals([0, 1, 2, 3, 4], $project->scoringValues);
    }

    public function testUploadingAnArrayOfStringsGetsConvertedToAnArrayOfIntsAccenture()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        $response = $this->actingAs($user)
            ->post('/accenture/newProjectSetUp/updateScoringValues', [
                'project_id' => $project->id,
                'values' => ['1', '3', '2', '2', '1']
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertEquals([1, 3, 2, 2, 1], $project->scoringValues);
    }

    public function testClientCanUpdateScoringValues()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $this->assertEquals([0, 0, 0, 0, 0], $project->scoringValues);

        $response = $this->actingAs($user)
            ->post('/client/newProjectSetUp/updateScoringValues', [
                'project_id' => $project->id,
                'values' => [0, 1, 2, 3, 4]
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertEquals([0, 1, 2, 3, 4], $project->scoringValues);
    }

    public function testUploadingAnArrayOfStringsGetsConvertedToAnArrayOfIntsClient()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this->actingAs($user)
            ->post('/client/newProjectSetUp/updateScoringValues', [
                'project_id' => $project->id,
                'values' => ['1', '3', '2', '2', '1']
            ]);

        $response->assertOk();

        $project->refresh();
        $this->assertEquals([1, 3, 2, 2, 1], $project->scoringValues);
    }
}
