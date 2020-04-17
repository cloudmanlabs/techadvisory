<?php

namespace Tests\Feature\Views\Accenture;

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
}
