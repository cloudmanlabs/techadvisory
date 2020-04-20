<?php

namespace Tests\Feature\Views\Accenture;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorListTest extends TestCase
{
    use RefreshDatabase;

    public function testWorks()
    {
        $user = factory(User::class)->states('accenture')->create();
        $response = $this
                ->actingAs($user)
                ->get('accenture/vendorList');

        $response->assertStatus(200);
    }

    public function testShowsVendors()
    {
        $user = factory(User::class)->states('accenture')->create();

        $vendor1 = factory(User::class)->states('vendor')->create();
        $vendor2 = factory(User::class)->states('vendor')->create();


        $response = $this
            ->actingAs($user)
            ->get('accenture/vendorList');

        $response->assertStatus(200)
            ->assertSee($vendor1->name)
            ->assertSee($vendor2->name);
    }

    public function testCanCreateVendorWithPost()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->assertCount(0, User::vendorUsers()->get());

        $response = $this->actingAs($user)
            ->post('accenture/createVendor');

        $response->assertRedirect();

        $this->assertCount(1, User::vendorUsers()->get());
    }
}
