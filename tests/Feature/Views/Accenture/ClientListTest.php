<?php

namespace Tests\Feature\Views\Accenture;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientListTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states('accenture')->create();
        $response = $this
            ->actingAs($user)
            ->get('accenture/clientList');

        $response->assertStatus(200);
    }

    public function testShowsClients()
    {
        $user = factory(User::class)->states('accenture')->create();

        $client1 = factory(User::class)->states('client')->create();
        $client2 = factory(User::class)->states('client')->create();


        $response = $this
            ->actingAs($user)
            ->get('accenture/clientList');

        $response->assertStatus(200)
            ->assertSee($client1->name)
            ->assertSee($client2->name);
    }

    public function testCanViewClientProfile()
    {
        $user = factory(User::class)->states('accenture')->create();

        $client = factory(User::class)->states('client')->create();

        $response = $this
            ->actingAs($user)
            ->get('accenture/clientProfileView/'.$client->id);

        $response->assertStatus(200)
            ->assertSee($client->name);
    }

    public function testCanEditClientProfile()
    {
        $user = factory(User::class)->states('accenture')->create();

        $client = factory(User::class)->states('client')->create();

        $response = $this
            ->actingAs($user)
            ->get('accenture/clientProfileEdit/' . $client->id);

        $response->assertStatus(200)
            ->assertSee($client->name);
    }

    public function testCanCreateClientWithPost()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->assertCount(0, User::clientUsers()->get());

        $response = $this->actingAs($user)
                    ->post('accenture/createClient');

        $response->assertRedirect();

        $this->assertCount(1, User::clientUsers()->get());
    }

    public function testCanChangeClientResponse()
    {
        $user = factory(User::class)->states('accenture')->create();

        $question = factory(ClientProfileQuestion::class)->create();
        $client = factory(User::class)->states('client')->create();

        $qResponse = new ClientProfileQuestionResponse([
            'question_id' => $question->id,
            'client_id' => $client->id,
        ]);
        $qResponse->save();

        $response = $this->actingAs($user)
            ->post('/accenture/clientProfileEdit/changeResponse', [
                'changing' => $qResponse->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $qResponse->refresh();
        $this->assertEquals('newText', $qResponse->response);
    }

    public function testCanChangeClientName()
    {
        $user = factory(User::class)->states('accenture')->create();
        $client = factory(User::class)->states('client')->create();

        $response = $this->actingAs($user)
            ->post('/accenture/clientProfileEdit/changeName', [
                'client_id' => $client->id,
                'value' => 'newText'
            ]);

        $response->assertOk();

        $client->refresh();
        $this->assertEquals('newText', $client->name);
    }
}
