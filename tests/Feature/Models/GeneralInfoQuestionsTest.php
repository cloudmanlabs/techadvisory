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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanCreateGeneralInfoQuestion()
    {
        $this->assertCount(0, GeneralInfoQuestion::all());

        $question = new GeneralInfoQuestion([
            'question' => 'How are you?',
            'type' => 'text'
        ]);
        $question->save();

        $this->assertCount(1, GeneralInfoQuestion::all());
    }

    public function testCanAssignQuestionsToAProject()
    {
        $this->assertCount(0, GeneralInfoQuestionResponse::all());

        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();

        $response = new GeneralInfoQuestionResponse([
            'question_id' => $question->id,
            'project_id' => $project->id,
        ]);
        $response->save();

        $this->assertCount(1, GeneralInfoQuestionResponse::all());
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
