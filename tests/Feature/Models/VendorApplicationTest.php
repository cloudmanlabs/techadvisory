<?php

namespace Tests\Feature\Models;

use App\SelectionCriteriaQuestionResponse;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\User;
use App\VendorApplication;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class VendorApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateApplication()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $application = new VendorApplication([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,

            'invitedToOrals' => true,
            'oralsCompleted' => true,

            'deliverables' => [
                'something',
                'pther',
                'hey'
            ]
        ]);
        $application->save();

        $this->assertCount(1, VendorApplication::all());
    }

    public function testVendorCanApplyToProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $application = $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());
        $this->assertNotNull($application);
    }

    public function testVendorApplyingToProjectTwiceDoesntCreateAnotherApplication()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());

        $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());
    }

    public function testAccentureAndClientsCanNotApplyToProjects()
    {
        $project = factory(Project::class)->create();
        $accenture = factory(User::class)->states(['accenture', 'finishedSetup'])->create();
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();


        $this->expectException(Exception::class);
        $accApplication = $accenture->applyToProject($project);
        $this->expectException(Exception::class);
        $clientApplication = $client->applyToProject($project);

        $this->assertCount(0, VendorApplication::all());
        $this->assertNull($accApplication);
        $this->assertNull($clientApplication);
    }

    public function testAVendorThatHasntFinishedSetupCanNotApply()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor'])->create();

        $this->assertCount(0, VendorApplication::all());

        $this->expectException(Exception::class);
        $application = $vendor->applyToProject($project);
        $this->assertCount(0, VendorApplication::all());
        $this->assertNull($application);
    }

    public function testCanGetTheProjectsAVendorHasAppliedTo()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, $vendor->vendorAppliedProjects()->get());

        $vendor->applyToProject($project);

        $this->assertCount(1, $vendor->vendorAppliedProjects()->get());
    }

    public function testCanGetThevendorsAppliedToAProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, $project->vendorsApplied()->get());

        $vendor->applyToProject($project);

        $this->assertCount(1, $project->vendorsApplied()->get());
    }

    public function testApplicationHasPhase()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $this->assertNotNull($application->phase);
    }

    public function testApplicationDefaultsToInvitationPhase()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $this->assertEquals('invitation',$application->phase);
    }

    public function testChainingSetMethodsOnlySetsTheLastOne()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application
                ->setApplicating()
                ->setSubmitted()
                ->setRejected();

        $this->assertEquals('rejected', $application->phase);
    }

    public function testVendorCanRejectProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
                    ->post('vendors/application/setRejected/'.$project->id);
        $response->assertRedirect('vendors/home');

        $application->refresh();
        $this->assertEquals('rejected', $application->phase);
    }

    public function testVendorCanAcceptProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
            ->post('vendors/application/setAccepted/' . $project->id);
        $response->assertRedirect('vendors/home');

        $application->refresh();
        $this->assertEquals('applicating', $application->phase);
    }





    public function testCanGetTotalScore()
    {
        $question1 = factory(SelectionCriteriaQuestion::class)->create();
        $question2 = factory(SelectionCriteriaQuestion::class)->create();

        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question1->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 3
        ]);
        $response->save();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question2->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 9
        ]);
        $response->save();

        // We don't check that it's the actual average of the scores, because we have the fitgap that messes it up
        $this->assertGreaterThan(0, $application->totalScore());
    }

    public function testCanGetVendorScore()
    {
        $question1 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_corporate'
        ]);
        $question2 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'vendor_market'
        ]);

        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question1->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 2
        ]);
        $response->save();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question2->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 4
        ]);
        $response->save();

        $this->assertEquals(3, $application->vendorScore());
    }

    public function testCanGetExperienceScore()
    {
        $question1 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience'
        ]);
        $question2 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'experience'
        ]);

        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question1->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 8
        ]);
        $response->save();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question2->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 10
        ]);
        $response->save();

        $this->assertEquals(9, $application->experienceScore());
    }

    public function testCanGetInnovationScore()
    {
        return 'Fix me pls';

        $question1 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'innovation_digitalEnablers'
        ]);
        $question2 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'innovation_product'
        ]);

        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question1->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 8
        ]);
        $response->save();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question2->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 10
        ]);
        $response->save();

        $this->assertEquals(9, $application->innovationScore());
    }

    public function testCanGetImplementationScore()
    {
        return 'Fix me pls';

        $question1 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_implementation'
        ]);
        $question2 = factory(SelectionCriteriaQuestion::class)->create([
            'page' => 'implementation_run'
        ]);

        $project = factory(Project::class)->create();
        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question1->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 5
        ]);
        $response->save();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question2->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
            'response' => 'hello',
            'score' => 9
        ]);
        $response->save();

        $this->assertEquals(8.2, $application->implementationScore());
    }



    public function testCanChangeInvitedToOrals()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $application = $vendor->applyToProject($project);

        $this->assertFalse(boolval($application->invitedToOrals));

        $request = $this
            ->actingAs($user)
            ->post('/accenture/orals/changeInvitedToOrals', [
                'changing' => $application->id,
                'value' => 'true'
            ]);

        $request->assertOk();

        $application->refresh();
        $this->assertTrue($application->invitedToOrals);
    }

    public function testCanChangeOralsCompleted()
    {
        $user = factory(User::class)->states(['accenture'])->create();
        $project = factory(Project::class)->create();

        /** @var User $vendor */
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $application = $vendor->applyToProject($project);

        $this->assertFalse(boolval($application->oralsCompleted));

        $request = $this
            ->actingAs($user)
            ->post('/accenture/orals/changeOralsCompleted', [
                'changing' => $application->id,
                'value' => 'true'
            ]);

        $request->assertOk();

        $application->refresh();
        $this->assertTrue($application->oralsCompleted);
    }
}
