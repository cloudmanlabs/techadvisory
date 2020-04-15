<?php

namespace Tests\Feature\Views\Client;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testClientCanAccessProfilePage()
    {
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $response = $this->actingAs($client)
                        ->get('client/profile');

        $response->assertOk();
    }

    public function testCanSeeOwnName()
    {
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $response = $this->actingAs($client)
            ->get('client/profile');

        $response->assertOk();
        $response->assertSee($client->name);
    }

    public function testCanSeeAddedQuestions()
    {
        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $qResponse = new ClientProfileQuestionResponse([
            'question_id' => $question->id,
            'client_id' => $client->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($client)
            ->get('client/profile');

        $response->assertOk();
        $response->assertSee($question->label);
    }

    public function testCanNotAccessIfClientHasNotFinishedSetUp()
    {
        $user = factory(User::class)->states('client')->create();
        $response = $this
            ->actingAs($user)
            ->get('/client/profile');

        $response->assertStatus(404);
    }
}
