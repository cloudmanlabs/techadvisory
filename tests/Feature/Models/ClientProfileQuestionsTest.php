<?php

namespace Tests\Feature\Models;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientProfileQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateClientProfileQuestion()
    {
        $this->assertCount(0, ClientProfileQuestion::all());

        $question = new ClientProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text'
        ]);
        $question->save();

        $this->assertCount(1, ClientProfileQuestion::all());
    }

    public function testCanCreateClientProfileQuestionWithPlaceholder()
    {
        $this->assertCount(0, ClientProfileQuestion::all());

        $question = new ClientProfileQuestion([
            'label' => 'How are you?',
            'type' => 'text',

            'placeholder' => 'HELLOOOOO'
        ]);
        $question->save();

        $this->assertCount(1, ClientProfileQuestion::all());
    }

    public function testCanRespondQuestion()
    {
        // Create the question
        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();
        $response = new ClientProfileQuestionResponse([
            'client_id' => $client->id,
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
        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $this->assertCount(1, $client->clientProfileQuestions);

        $question->delete();

        $client->refresh();
        $this->assertCount(0, $client->clientProfileQuestions);
    }

    public function testChangingAQuestionResetsTheResponses()
    {
        $question = factory(ClientProfileQuestion::class)->create([
            'type' => 'selectMultiple',
            'label' => 'Transport Type',
            'presetOption' => 'transportTypes'
        ]);
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        // Set a response
        $response = ClientProfileQuestionResponse::first();
        $this->assertNull($response->response);
        $response->response = 'hello';
        $response->save();
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
        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states('client')->create();

        $qResponse = new ClientProfileQuestionResponse([
            'question_id' => $question->id,
            'client_id' => $client->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($client)
            ->post('/client/profile/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testClientCanOnlyChangeOwnProfileQuestionResponses()
    {
        $question = factory(ClientProfileQuestion::class)->create();
        $owner = factory(User::class)->states('client')->create();
        $changer = factory(User::class)->states('client')->create();

        $qResponse = new ClientProfileQuestionResponse([
            'question_id' => $question->id,
            'client_id' => $owner->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($changer)
            ->post('/client/profile/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertStatus(403);

        $qResponse->refresh();
        $this->assertNull($qResponse->response);
    }
}
