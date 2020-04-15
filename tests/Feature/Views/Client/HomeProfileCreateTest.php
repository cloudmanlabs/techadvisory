<?php

namespace Tests\Feature\Views\Client;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeProfileCreateTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAccessFirstLoginRegistration()
    {
        $user = factory(User::class)->states('client')->create();

        $response = $this->actingAs($user)
                        ->get('client/firstLoginRegistration');

        $response->assertOk();
    }

    public function testCanAccessHomeProfileCreateView()
    {
        $user = factory(User::class)->states('client')->create();

        $response = $this->actingAs($user)
            ->get('client/profile/create');

        $response->assertOk();
    }

    public function testCanSeeOwnName()
    {
        $client = factory(User::class)->states('client')->create();

        $response = $this->actingAs($client)
            ->get('client/profile/create');

        $response->assertOk();
        $response->assertSee($client->name);
    }

    public function testCanSeeAddedQuestions()
    {
        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states('client')->create();

        $qResponse = new ClientProfileQuestionResponse([
            'question_id' => $question->id,
            'client_id' => $client->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($client)
            ->get('client/profile/create');

        $response->assertOk();
        $response->assertSee($question->label);
    }

    public function testCanSubmitProfile()
    {
        $client = factory(User::class)->states('client')->create();

        $this->assertFalse(boolval($client->hasFinishedSetup));

        $response = $this->actingAs($client)
            ->post('client/profile/submit');

        $response->assertRedirect('client/home');

        $this->assertTrue($client->hasFinishedSetup);
    }
}
