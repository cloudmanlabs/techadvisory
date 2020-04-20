<?php

namespace Tests\Feature\Models;

use App\User;
use App\VendorSolution;
use App\VendorSolutionQuestion;
use App\VendorSolutionQuestionResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorSolutionQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateQuestion()
    {
        $this->assertCount(0, VendorSolutionQuestion::all());

        $question = new VendorSolutionQuestion([
            'label' => 'How are you?',
            'type' => 'text',
        ]);
        $question->save();

        $this->assertCount(1, VendorSolutionQuestion::all());
    }

    public function testCanCreateVendorSolutionQuestionWithPlaceholder()
    {
        $this->assertCount(0, VendorSolutionQuestion::all());

        $question = new VendorSolutionQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'HELLOOOOO'
        ]);
        $question->save();

        $this->assertCount(1, VendorSolutionQuestion::all());
    }

    public function setUpQuestionResponse()
    {
        $question = factory(VendorSolutionQuestion::class)->create();
        factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create()
            ->each(function ($user) {
                $user->vendorSolutions()->save(factory(VendorSolution::class)->make());
            });
        $vendor = User::vendorUsers()->first();
        $solution = $vendor->vendorSolutions->first();

        // Set a response
        $response = VendorSolutionQuestionResponse::first();

        return [
            $vendor,
            $solution,
            $question,
            $response
        ];
    }

    public function testCanRespondQuestion()
    {
        list($vendor, $solution, $question, $qResponse) = $this->setUpQuestionResponse();

        $response = new VendorSolutionQuestionResponse([
            'solution_id' => $solution->id,
            'question_id' => $question->id,
        ]);
        $response->save();

        $this->assertNull($response->response);
        $response->response = 'answer';
        $response->save();
        $this->assertNotNull($response->response);
    }

    public function testResponseIsDeletedWhenQuestionIsDeleted()
    {
        list($vendor, $solution, $question, $qResponse) = $this->setUpQuestionResponse();

        $this->assertCount(1, $solution->questions);

        $question->delete();

        $solution->refresh();
        $this->assertCount(0, $solution->questions);
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        list($vendor, $solution, $question, $response) = $this->setUpQuestionResponse();

        $this->assertNull($response->response);
        $response->response = 'hello';
        $response->save();
        $response->refresh();
        $this->assertNotNull($response->response);

        // Change the question
        $question->type = 'selectSingle';
        $question->save();

        // Check that the response was reset
        $response->refresh();
        $this->assertNull($response->response);
    }

    public function testCanChangeResponseWithPost()
    {
        list($vendor, $solution, $question, $qResponse) = $this->setUpQuestionResponse();

        $response = $this->actingAs($vendor)
            ->post('/vendors/solution/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testVendorCanOnlyChangeOwnProfileQuestionResponses()
    {
        list($owner, $solution, $question, $qResponse) = $this->setUpQuestionResponse();
        $changer = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this->actingAs($changer)
            ->post('/vendors/solution/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertStatus(403);

        $qResponse->refresh();
        $this->assertNull($qResponse->response);
    }
}
