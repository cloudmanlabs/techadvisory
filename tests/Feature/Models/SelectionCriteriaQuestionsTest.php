<?php

namespace Tests\Feature\Models;

use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\User;
use App\VendorApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelectionCriteriaQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateSelectionCriteriaQuestion()
    {
        $this->assertCount(0, SelectionCriteriaQuestion::all());

        $question = new SelectionCriteriaQuestion([
            'label' => 'How are you?',
            'type' => 'text',
        ]);
        $question->save();

        $this->assertCount(1, SelectionCriteriaQuestion::all());
    }

    public function testCanCreateSelectionCriteriaQuestionWithPlaceholder()
    {
        $this->assertCount(0, SelectionCriteriaQuestion::all());

        $question = new SelectionCriteriaQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'PH'
        ]);
        $question->save();

        $this->assertCount(1, SelectionCriteriaQuestion::all());
    }

    public function testCanCreateSelectionCriteriaQuestionWithRequired()
    {
        $this->assertCount(0, SelectionCriteriaQuestion::all());

        $question = new SelectionCriteriaQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'required' => true
        ]);
        $question->save();

        $this->assertCount(1, SelectionCriteriaQuestion::all());
    }

    public function testCanCreateSelectionCriteriaQuestionWithPage()
    {
        $this->assertCount(0, SelectionCriteriaQuestion::all());

        $question = new SelectionCriteriaQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'page' => 'fitgap'
        ]);
        $question->save();

        $this->assertCount(1, SelectionCriteriaQuestion::all());
    }

    public function testCanAssignQuestionsToAProject()
    {
        $this->assertCount(0, SelectionCriteriaQuestionResponse::all());

        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        // We generate a random question that gets assigned when we apply to the project
        factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor->applyToProject($project);

        $this->assertCount(1, SelectionCriteriaQuestionResponse::all());
        $this->assertCount(1, $project->selectionCriteriaQuestionsForVendor($vendor)->get());

        // We then assign a new one
        $question = factory(SelectionCriteriaQuestion::class)->create();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ]);
        $response->save();

        $project->refresh();
        $this->assertCount(2, $project->selectionCriteriaQuestionsForVendor($vendor)->get());
    }









    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ]);
        $response->save();

        $this->assertNull($response->response);
        $response->response = 'answer';
        $response->save();
        $this->assertNotNull($response->response);
    }

    public function testResponseIsDeletedWhenQuestionIsDeleted()
    {
        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $this->assertCount(1, $project->selectionCriteriaQuestionsForVendor($vendor)->get());

        $question->delete();

        $project->refresh();
        $this->assertCount(0, $project->selectionCriteriaQuestionsForVendor($vendor)->get());
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        $question = factory(SelectionCriteriaQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'required' => false,
            'presetOption' => 'transportTypes'
        ]);
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        // Set a response
        $response = SelectionCriteriaQuestionResponse::first();
        $this->assertNull($response->response);
        $response->response = 'hello';
        $this->assertNotNull($response->response);

        // Change the question
        $question->type = 'selectSingle';
        $question->save();

        // CHekc that the response was reset
        $response->refresh();
        $this->assertNull($response->response);
    }

    public function testAddingAndRemovingAVendorFromAProjectDoesntCreateResponsesTwice()
    {
        $question = factory(SelectionCriteriaQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'required' => false,
            'presetOption' => 'transportTypes'
        ]);
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        // Response gets added by observer
        $this->assertCount(1, SelectionCriteriaQuestionResponse::all());

        $application = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();
        $application->delete();

        // Response is still here
        $this->assertCount(1, SelectionCriteriaQuestionResponse::all());

        $vendor->applyToProject($project);

        // No other responses should get added
        $this->assertCount(1, SelectionCriteriaQuestionResponse::all());
    }

    public function testCanGetTheListOfOriginalQuestionsFromAProject()
    {
        $project = factory(Project::class)->create();

        $question1 = factory(SelectionCriteriaQuestion::class)->create();
        $question2 = factory(SelectionCriteriaQuestion::class)->create();
        $question3 = factory(SelectionCriteriaQuestion::class)->create();

        $vendor1 = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor2 = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor3 = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $vendor1->applyToProject($project);
        $vendor2->applyToProject($project);
        $vendor3->applyToProject($project);

        $this->assertCount(9, SelectionCriteriaQuestionResponse::all()); // We should have 9, 3 vendors x 3 questions

        $this->assertCount(3, $project->selectionCriteriaQuestionsOriginals());
    }

    public function testCanChangeResponseWithPost()
    {
        $user = factory(User::class)->create();

        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $vendor->applyToProject($project);

        $this->assertCount(1, SelectionCriteriaQuestionResponse::all()); // Just making sure
        $qResponse = SelectionCriteriaQuestionResponse::first();

        $response = $this->actingAs($user)
            ->post('/selectionCriteriaQuestion/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }
}
