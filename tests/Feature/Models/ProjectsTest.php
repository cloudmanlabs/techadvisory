<?php

namespace Tests\Feature;

use App\Mail\ProjectInvitationEmail;
use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use Carbon\Carbon;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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

            'currentPhase' => 'open',

            'deadline' => Carbon::now()
                                ->addMonth()
                                ->addWeek()
                                ->toDateTimeString(),

            'practice_id' => 1,
            'client_id' => 1,

            'oralsLocation' => 'My house',
            'oralsFromDate' => Carbon::now()
                                    ->addWeek()
                                    ->toDateTimeString(),
            'oralsToDate' => Carbon::now()
                                    ->addMonth()
                                    ->addWeek()
                                    ->toDateTimeString(),

            'rfpOtherInfo' => 'Hello my friends',

            'fitgapWeightMust' => 10,
            'fitgapWeightRequired' => 10,
            'fitgapWeightNiceToHave' => 10,

            'fitgapFunctionalWeight' => 10,
            'fitgapTechnicalWeight' => 10,
            'fitgapServiceWeight' => 10,
            'fitgapOthersWeight' => 10,
            'implementationImplementationWeight' => 10,
            'implementationRunWeight' => 10,
        ]);
        $project->save();

        $this->assertCount(1, Project::all());
    }

    public function testCreatingAProjectWithoutWeightsSetsTheValuesToTheDefaults()
    {
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

        $project->refresh();
        $this->assertEquals(10, $project->fitgapWeightMust);
        $this->assertEquals(5, $project->fitgapWeightRequired);
        $this->assertEquals(1, $project->fitgapWeightNiceToHave);
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

        $this->assertCount(1, Project::preparationProjects());
        $this->assertCount(0, Project::openProjects());
        $this->assertCount(0, Project::oldProjects());
    }

    public function testObserverAddsFoldersToProject()
    {
        $project = factory(Project::class)->create();

        $this->assertNotNull($project->conclusionsFolder);
        $this->assertNotNull($project->selectedValueLeversFolder);
        $this->assertNotNull($project->businessOpportunityFolder);
        $this->assertNotNull($project->vtConclusionsFolder);
        $this->assertNotNull($project->rfpFolder);
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
                ->assertRedirect(route('accenture.newProjectSetUp', ['project'=> $project, 'firstTime' => true]));
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

    public function testCanChangeHasOralsInProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create([
            'hasOrals' => false
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeProjectHasOrals', [
                'project_id' => $project->id,
                'value' => 'yes'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals(1, $project->hasOrals);
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

    public function testCanChangeIndustryInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeIndustry', [
                'project_id' => $project->id,
                'value' => 'consumer'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('consumer', $project->industry);
    }

    public function testCanChangeRegionsInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeRegions', [
                'project_id' => $project->id,
                'value' => ['latam', 'apac']
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue(in_array('latam', $project->regions));
    }

    public function testCanChangeProjectTypeInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeProjectType', [
                'project_id' => $project->id,
                'value' => 'Business Case'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('Business Case', $project->projectType);
    }


    public function testCanChangeDeadlineInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeDeadline', [
                'project_id' => $project->id,
                'value' => '10/23/2030'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('23', $project->deadline->day);
        $this->assertEquals('10', $project->deadline->month);
        $this->assertEquals('2030', $project->deadline->year);
    }

    public function testCanChangeRFPOtherInfoProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeRFPOtherInfo', [
                'project_id' => $project->id,
                'value' => 'Hey hey hey my friendooos'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('Hey hey hey my friendooos', $project->rfpOtherInfo);
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
        $project = factory(Project::class)->create([
            'step3SubmittedAccenture' => true
        ]);

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
        $project = factory(Project::class)->create([
            'step4SubmittedAccenture' => true
        ]);

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

    public function testAccentureCanPublishAnalyticsInProject()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $this->assertFalse(boolval($project->publishedAnalytics));

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/togglePublishProjectAnalytics', ['project_id' => $project->id]);

        $request->assertOk();

        $project->refresh();
        $this->assertTrue($project->publishedAnalytics);
    }

    public function testAccentureCanUpdateScoringValues()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        $this->assertEquals([4, 4, 4, 4, 4], $project->scoringValues);

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

        $this->assertEquals([4,4,4,4,4], $project->scoringValues);

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

    public function testAccentureCanChangeOralsLocations()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/orals/changeLocation', [
                'project_id' => $project->id,
                'location' => 'Barcelona'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('Barcelona', $project->oralsLocation);
    }

    public function testCanChangeOralsFromDateInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/orals/changeFromDate', [
                'project_id' => $project->id,
                'value' => '10/23/2030'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('23', $project->oralsFromDate->day);
        $this->assertEquals('10', $project->oralsFromDate->month);
        $this->assertEquals('2030', $project->oralsFromDate->year);
    }

    public function testCanChangeToDateInProject()
    {
        $user = factory(User::class)->states('accenture')->create();

        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/orals/changeToDate', [
                'project_id' => $project->id,
                'value' => '10/23/2030'
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals('23', $project->oralsToDate->day);
        $this->assertEquals('10', $project->oralsToDate->month);
        $this->assertEquals('2030', $project->oralsToDate->year);
    }

    public function testSettingStep3AccentureAsFalseChangesForClient()
    {
        $project = factory(Project::class)->create([
            'step3SubmittedAccenture' => true,
            'step3SubmittedClient' => true,
        ]);

        $this->assertTrue($project->step3SubmittedAccenture);
        $this->assertTrue($project->step3SubmittedClient);

        $project->step3SubmittedAccenture = false;
        $project->save();
        $project->refresh();

        $this->assertFalse($project->step3SubmittedAccenture);
        $this->assertFalse($project->step3SubmittedClient);
    }

    public function testSettingStep4AccentureAsFalseChangesForClient()
    {
        $project = factory(Project::class)->create([
            'step4SubmittedAccenture' => true,
            'step4SubmittedClient' => true,
        ]);

        $this->assertTrue($project->step4SubmittedAccenture);
        $this->assertTrue($project->step4SubmittedClient);

        $project->step4SubmittedAccenture = false;
        $project->save();
        $project->refresh();

        $this->assertFalse($project->step4SubmittedAccenture);
        $this->assertFalse($project->step4SubmittedClient);
    }

    public function testCanSendReinvitationEmail()
    {
        Mail::fake();

        $user = factory(User::class)->states('accenture')->create();

        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $vendor->applyToProject($project);

        $this->withoutExceptionHandling();
        $response = $this->actingAs($user)
                    ->post('/accenture/project/resendInvitation', [
                        'vendor_id' => $vendor->id,
                        'project_id' => $project->id,
                        'text' => 'hello',
                        'email' => 'hello@example.com'
                    ]);
        $response->assertOk();

        Mail::assertSent(ProjectInvitationEmail::class, function ($mail) use ($vendor) {
            return $mail->hasTo('hello@example.com');
        });
    }

    public function testAccentureCanChangeFitgapAndImplementationWeightsWithPost()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create();

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeWeights', [
                'project_id' => $project->id,
                'changing' => 'fitgapWeightMust',
                'value' => 12
            ]);

        $request->assertOk();

        $project->refresh();
        $this->assertEquals(12, $project->fitgapWeightMust);
    }

    public function testCantChangeOtherFieldsWithChangeWeightsPost()
    {
        $user = factory(User::class)->states('accenture')->create();
        $project = factory(Project::class)->create([
            'name' => 'old'
        ]);

        $request = $this
            ->actingAs($user)
            ->post('/accenture/newProjectSetUp/changeWeights', [
                'project_id' => $project->id,
                'changing' => 'name',
                'value' => 'hello'
            ]);

        $request->assertStatus(302);

        $project->refresh();
        $this->assertEquals('old', $project->name);
    }
}
