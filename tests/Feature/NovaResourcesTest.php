<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class NovaResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function testAccentureCanNotAccessUsers()
    {
        $accenture = factory(User::class)->states('accenture')->make();

        $response = $this->actingAs($accenture)
            ->get('/nova-api/users');
        $response->assertStatus(404);
    }

    public function testAdminCanAccessUsers()
    {
        $admin = factory(User::class)->states('admin')->make();

        $response = $this->actingAs($admin)
            ->get('/nova-api/users/cards');
        $response->assertStatus(200);
    }
}
