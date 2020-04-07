<?php

namespace Tests\Feature\Models;

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
}
