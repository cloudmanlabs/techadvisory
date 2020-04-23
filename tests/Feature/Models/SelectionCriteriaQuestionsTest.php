<?php

namespace Tests\Feature\Models;

use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\User;
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

    public function testCanAssignQuestionsToAProject()
    {
        $this->assertCount(0, SelectionCriteriaQuestionResponse::all());

        // We generate a random question that gets assigned with the observer
        factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->selectionCriteriaQuestions);

        // We then assign a new one

        $question = factory(SelectionCriteriaQuestion::class)->create();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $response->save();

        $project->refresh();
        $this->assertCount(2, $project->selectionCriteriaQuestions);
    }

    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $response = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
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

        $this->assertCount(1, $project->selectionCriteriaQuestions);

        $question->delete();

        $project->refresh();
        $this->assertCount(0, $project->selectionCriteriaQuestions);
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

    public function testCanChangeResponseWithPost()
    {
        $user = factory(User::class)->create();

        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $qResponse = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($user)
            ->post('/selectionCriteriaQuestion/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testCanChangeShouldShow()
    {
        $user = factory(User::class)->create();

        $question = factory(SelectionCriteriaQuestion::class)->create();
        $project = factory(Project::class)->create();
        $qResponse = new SelectionCriteriaQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $qResponse->save();

        $this->assertFalse(boolval($qResponse->shouldShow));

        $response = $this->actingAs($user)
            ->post('/selectionCriteriaQuestion/setShouldShow', [
                'changing' => $qResponse->id,
                'value' => 'true'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertTrue($qResponse->shouldShow);
    }
}
