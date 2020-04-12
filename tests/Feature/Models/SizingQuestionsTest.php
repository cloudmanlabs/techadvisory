<?php

namespace Tests\Feature\Models;

use App\Practice;
use App\Project;
use App\SizingQuestion;
use App\SizingQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SizingQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateSizingQuestion()
    {
        $this->assertCount(0, SizingQuestion::all());

        $question = new SizingQuestion([
            'label' => 'How are you?',
            'type' => 'text',
        ]);
        $question->save();

        $this->assertCount(1, SizingQuestion::all());
    }

    public function testCanCreateSizingQuestionWithPlaceholder()
    {
        $this->assertCount(0, SizingQuestion::all());

        $question = new SizingQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'PH'
        ]);
        $question->save();

        $this->assertCount(1, SizingQuestion::all());
    }

    public function testCanCreateSizingQuestionWithRequired()
    {
        $this->assertCount(0, SizingQuestion::all());

        $question = new SizingQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'required' => true
        ]);
        $question->save();

        $this->assertCount(1, SizingQuestion::all());
    }

    public function testCanSizingQuestionWithPracticeDependency()
    {
        $this->assertCount(0, SizingQuestion::all());

        $practice = factory(Practice::class)->create();

        $question = new SizingQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'practice_id' => $practice->id
        ]);
        $question->save();

        $this->assertCount(1, SizingQuestion::all());
    }

    public function testCanAttachPracticeToSizingQuestion()
    {
        $practice = factory(Practice::class)->create();

        $question = new SizingQuestion([
            'label' => 'How are you?',
            'type' => 'text',
        ]);
        $question->save();

        $this->assertNull($question->practice);

        $question->practice()->associate($practice);
        $question->save();

        $question->refresh();

        $this->assertNotNull($question->practice);
    }

    public function testCanAssignQuestionsToAProject()
    {
        $this->assertCount(0, SizingQuestionResponse::all());

        // We generate a random question that gets assigned with the observer
        factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->sizingQuestions);

        // We then assign a new one

        $question = factory(SizingQuestion::class)->create();
        $response = new SizingQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $response->save();

        $project->refresh();
        $this->assertCount(2, $project->sizingQuestions);
    }


    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();
        $response = new SizingQuestionResponse([
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
        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();

        $this->assertCount(1, $project->sizingQuestions);

        $question->delete();

        $project->refresh();
        $this->assertCount(0, $project->sizingQuestions);
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        $question = factory(SizingQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'required' => false,
            'presetOption' => 'transportTypes'
        ]);
        $project = factory(Project::class)->create();

        // Set a response
        $response = SizingQuestionResponse::first();
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

        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();
        $qResponse = new SizingQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($user)
                        ->post('/sizingQuestion/changeResponse', [
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

        $question = factory(SizingQuestion::class)->create();
        $project = factory(Project::class)->create();
        $qResponse = new SizingQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $qResponse->save();

        $this->assertFalse(boolval($qResponse->shouldShow));

        $response = $this->actingAs($user)
            ->post('/sizingQuestion/setShouldShow', [
                'changing' => $qResponse->id,
                'value' => 'true'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertTrue($qResponse->shouldShow);
    }
}
