<?php

namespace Tests\Feature\Views\Vendor;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $response = $this
            ->actingAs($user)
            ->get('/vendors/home');

        $response->assertStatus(200);
    }

    public function testCanNotAccessIfVendorHasNotFinishedSetUp()
    {
        $user = factory(User::class)->states('vendor')->create();
        $response = $this
            ->actingAs($user)
            ->get('/vendors/home');

        $response->assertStatus(404);
    }
}
