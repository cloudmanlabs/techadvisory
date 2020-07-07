<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NovaTest extends TestCase
{
    public function testNovaRedirectsToLogin()
    {
        $response = $this->get('/admin/');
        $response
            ->assertStatus(302)
            ->assertRedirect('/admin/login');
    }

    public function testAdminCanAccessNova()
    {
        $user = factory(User::class)->states('admin')->make();

        $response = $this->actingAs($user)
            ->get('/admin/');
        $response->assertStatus(200);
    }

    public function testAccentureAdminCanAccessNova()
    {
        $user = factory(User::class)->states('accentureAdmin')->make();

        $response = $this->actingAs($user)
            ->get('/admin/');
        $response->assertStatus(200);
    }


    public function testAccentureCanNotAccessNova()
    {
        $user = factory(User::class)->states('accenture')->make();

        $response = $this->actingAs($user)
            ->get('/admin/');
        $response->assertStatus(403);
    }

    public function testVendorCanNotAccessNova()
    {
        $user = factory(User::class)->states('vendor')->make();

        $response = $this->actingAs($user)
            ->get('/admin/');
        $response->assertStatus(403);
    }

    public function testClientCanNotAccessNova()
    {
        $user = factory(User::class)->states(['client', 'finishedSetup'])->make();

        $response = $this->actingAs($user)
            ->get('/admin/');
        $response->assertStatus(403);
    }
}
