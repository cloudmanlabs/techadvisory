<?php

namespace Tests\Feature\Models;

use App\SizingQuestion;
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
            'question' => 'How are you?',
            'type' => 'string'
        ]);
        $question->save();

        $this->assertCount(1, SizingQuestion::all());
    }
}
