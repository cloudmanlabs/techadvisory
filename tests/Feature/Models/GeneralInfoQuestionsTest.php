<?php

namespace Tests\Feature\Models;

use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function testCanAssignQuestionsToAProject()
    {
        $this->assertCount(0, GeneralInfoQuestionResponse::all());

        // We generate a random question that gets assignes with the observer
        factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();

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
}
