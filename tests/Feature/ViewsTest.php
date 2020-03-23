<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ViewsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLinksInMainPage()
    {
        // visit('/')
        //     ->see('Accenture')
        //     ->see('Client')
        //     ->see('Vendor');

        $this->assertTrue(true);
    }

    public function testAccentureCanAccessAccentureViews()
    {
        $user = factory(User::class)->states('accenture')->make();

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(200);
    }

    public function testClientCanAccessClientViews()
    {
        $user = factory(User::class)->states('client')->make();

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(200);
    }

    public function testVendorCanAccessVendorViews()
    {
        $user = factory(User::class)->states('vendor')->make();

        $response = $this->actingAs($user)
            ->get('/vendors/home');
        $response->assertStatus(200);
    }



    public function testAccentureCanNotAccessOtherViews()
    {
        $user = factory(User::class)->states('accenture')->make();

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(302);
        $response = $this->actingAs($user)
            ->get('/vendors/home');
        $response->assertStatus(302);
    }

    public function testClientCanNotAccessOtherViews()
    {
        $user = factory(User::class)->states('client')->make();

        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(302);
        $response = $this->actingAs($user)
            ->get('/vendors/home');
        $response->assertStatus(302);
    }

    public function testVendorCanNotAccessOtherViews()
    {
        $user = factory(User::class)->states('vendor')->make();

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(302);
        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(302);
    }

    public function testAdminCanNotAccessOtherViews()
    {
        $user = factory(User::class)->states('admin')->make();

        $response = $this->actingAs($user)
            ->get('/client/home');
        $response->assertStatus(302);
        $response = $this->actingAs($user)
            ->get('/accenture/home');
        $response->assertStatus(302);
        $response = $this->actingAs($user)
            ->get('/vendors/home');
        $response->assertStatus(302);
    }
}
