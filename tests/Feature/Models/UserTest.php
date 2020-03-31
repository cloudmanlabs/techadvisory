<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testSeederWorks()
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@admin.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'accenture@accenture.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'client@client.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'vendor@vendor.com',
        ]);
    }

    public function testCanCreateAdmin()
    {
        $user = factory(User::class)->states('admin')->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@admin.com',
        ]);
    }

    public function testCanCreateClient()
    {
        $user = factory(User::class)->states('client')->create([
            'name' => 'client',
            'email' => 'client@client.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'client@client.com',
        ]);

        $user = User::where('email', 'client@client.com')->first();
        $this->assertTrue($user->isClient());
    }

    public function testCanCreateAccenture()
    {
        $user = factory(User::class)->states('accenture')->create([
            'name' => 'accenture',
            'email' => 'accenture@accenture.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'accenture@accenture.com',
        ]);

        $user = User::where('email', 'accenture@accenture.com')->first();
        $this->assertTrue($user->isAccenture());
    }

    public function testCanCreateVendor()
    {
        $user = factory(User::class)->states('vendor')->create([
            'name' => 'vendor',
            'email' => 'vendor@vendor.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'vendor@vendor.com',
        ]);

        $user = User::where('email', 'vendor@vendor.com')->first();
        $this->assertTrue($user->isVendor());
    }

    public function testUserAccenturesReturnsAQueryBuilder()
    {
        factory(User::class, 2)->states('accenture')->create();

        $col = User::accentureUsers();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $col);
    }

    public function testUserClientsReturnsAQueryBuilder()
    {
        factory(User::class, 2)->states('client')->create();

        $col = User::clientUsers();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $col);
    }

    public function testUserVendorsReturnsAQueryBuilder()
    {
        factory(User::class, 2)->states('vendor')->create();

        $col = User::vendorUsers();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $col);
    }



    private function generateSomeUsers()
    {
        factory(User::class, 3)->states('accenture')->create();
        factory(User::class, 5)->states('vendor')->create();
        factory(User::class, 7)->states('client')->create();
        factory(User::class, 11)->states('admin')->create();
    }

    public function testUserAccentureUsersWorks()
    {
        $this->generateSomeUsers();

        $count = User::accentureUsers()->count();
        $this->assertEquals(3, $count);
    }

    public function testUserClientUsersWorks()
    {
        $this->generateSomeUsers();

        $count = User::clientUsers()->count();
        $this->assertEquals(7, $count);
    }

    public function testUserVendorUsersWorks()
    {
        $this->generateSomeUsers();

        $count = User::vendorUsers()->count();
        $this->assertEquals(5, $count);
    }
}
