<?php

namespace Tests\Feature\Models;

use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GeneralInfoQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateGeneralInfoQuestion()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $question = new GeneralInfoQuestion([
            'label' => 'How are you?',
            'type' => 'text'
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanCreateGeneralInfoQuestionWithPlaceholder()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $question = new GeneralInfoQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'PH'
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanCreateGeneralInfoQuestionWithRequired()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $question = new GeneralInfoQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'required' => true
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanCreateGeneralInfoQuestionWithCanVendorSee()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $question = new GeneralInfoQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'canVendorSee' => true
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanCreateGeneralInfoQuestionWithPracticeDependency()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $practice = factory(Practice::class)->create();

        $question = new GeneralInfoQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'practice_id' => $practice->id
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanAttachPracticeToGeneralInfoQuestion()
    {
        $practice = factory(Practice::class)->create();

        $question = new GeneralInfoQuestion([
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
        $this->assertCount(0, GeneralInfoQuestionResponse::all());

        // We generate a random question that gets assigned with the observer
        factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $project->refresh();
        $this->assertCount(1, $project->generalInfoQuestions);

        // We then assign a new one

        $question = factory(GeneralInfoQuestion::class)->create();
        $response = new GeneralInfoQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $response->save();

        $project->refresh();
        $this->assertCount(2, $project->generalInfoQuestions);
    }

    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $response = new GeneralInfoQuestionResponse([
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
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $project->refresh();

        $this->assertCount(1, $project->generalInfoQuestions);

        $question->delete();

        $project->refresh();
        $this->assertCount(0, $project->generalInfoQuestions);
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        $question = factory(GeneralInfoQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'required' => false,
            'presetOption' => 'transportTypes'
        ]);
        $project = factory(Project::class)->create();

        // Set a response
        $response = GeneralInfoQuestionResponse::first();
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

        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $qResponse = new GeneralInfoQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($user)
            ->post('/generalInfoQuestion/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }
}
