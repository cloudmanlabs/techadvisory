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
}
