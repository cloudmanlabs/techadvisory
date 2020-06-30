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
        $accenture = factory(User::class)->states('accentureAdmin')->make();

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

    public function testAccenturesOnlyGivesAccentureUsers()
    {
        $admin = factory(User::class)->states('admin')->create();
        factory(User::class, 11)->states('accenture')->create();
        factory(User::class, 4)->states(['client', 'finishedSetup'])->create();
        factory(User::class, 3)->states('vendor')->create();

        $response = $this->actingAs($admin)
            ->get('/nova-api/accentures?search=&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(11, 'resources');
    }

    public function testClientsOnlyGivesClientUsers()
    {
        $admin = factory(User::class)->states('admin')->create();
        factory(User::class, 11)->states('accenture')->create();
        factory(User::class, 4)->states(['client', 'finishedSetup'])->create();
        factory(User::class, 3)->states('vendor')->create();

        $response = $this->actingAs($admin)
            ->get('/nova-api/clients?search=&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(4, 'resources');
    }

    public function testVendorsOnlyGivesVendorUsers()
    {
        $admin = factory(User::class)->states('admin')->create();
        factory(User::class, 11)->states('accenture')->create();
        factory(User::class, 4)->states(['client', 'finishedSetup'])->create();
        factory(User::class, 3)->states('vendor')->create();

        $response = $this->actingAs($admin)
            ->get('/nova-api/vendors?search=&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'resources');
    }



    private function generateUsersForSearch(string $type)
    {
        // We change the emails to make sure it doesn't interfere
        factory(User::class)->states($type)->create([
            'name' => 'someString',
            'email' => 'email1@email.com'
        ]);
        factory(User::class)->states($type)->create([
            'name' => 'someOther',
            'email' => 'email2@email.com'
        ]);

        factory(User::class)->states($type)->create([
            'name' => 'asdf',
            'email' => 'email3@email.com'
        ]);
        factory(User::class)->states($type)->create([
            'name' => 'qwer',
            'email' => 'email4@email.com'
        ]);
        factory(User::class)->states($type)->create([
            'name' => 'hjgfghj',
            'email' => 'email5@email.com'
        ]);
    }

    public function testUserSearchWorks()
    {
        $admin = factory(User::class)->states('admin')->create();

        $this->generateUsersForSearch('accenture');

        $response = $this->actingAs($admin)
            ->get('/nova-api/accentures?search=some&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'resources');
    }

    public function testClientSearchWorks()
    {
        $admin = factory(User::class)->states('admin')->create();

        $this->generateUsersForSearch('client');

        $response = $this->actingAs($admin)
            ->get('/nova-api/clients?search=some&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'resources');
    }

    public function testVendorSearchWorks()
    {
        $admin = factory(User::class)->states('admin')->create();

        $this->generateUsersForSearch('vendor');

        $response = $this->actingAs($admin)
            ->get('/nova-api/vendors?search=some&filters=W10%3D&orderBy=&perPage=100&trashed=&page=1&relationshipType=');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'resources');
    }
}
