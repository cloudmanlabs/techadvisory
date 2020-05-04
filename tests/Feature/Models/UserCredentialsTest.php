<?php

namespace Tests\Feature\Models;

use App\User;
use App\UserCredential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCredentialsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateCredentials()
    {
        $user = factory(User::class)->create();

        $credential = new UserCredential([
            'email' => 'test@test.com',
            'password' => 'password',

            'user_id' => $user->id
        ]);
        $credential->save();

        $this->assertCount(1, $user->credentials);
    }

    public function testCanCreateHiddenCredential()
    {
        $user = factory(User::class)->create();

        $credential = new UserCredential([
            'email' => 'test@test.com',
            'password' => 'password',

            'user_id' => $user->id,
            'hidden' => true
        ]);
        $credential->save();

        $this->assertCount(1, $user->credentials);
    }

    public function testClientCanLoginWithNormalEmail()
    {
        $user = factory(User::class)->states('client')->create([
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $response = $this->post(route('client.loginPost'), [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/client');
        $this->assertTrue(auth()->check());
    }

    public function testClientCanLoginUsingCredentials()
    {
        $user = factory(User::class)->states('client')->create();
        $user->credentials()->save(new UserCredential([
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]));

        $response = $this->post(route('client.loginPost'), [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/client');
        $this->assertTrue(auth()->check());
    }

    public function testVendorCanLoginWithNormalEmail()
    {
        $user = factory(User::class)->states('vendor')->create([
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $response = $this->post(route('vendor.loginPost'), [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/vendors');
        $this->assertTrue(auth()->check());
    }

    public function testVendorCanLoginUsingCredentials()
    {
        $user = factory(User::class)->states('vendor')->create();
        $user->credentials()->save(new UserCredential([
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]));

        $response = $this->post(route('vendor.loginPost'), [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/vendors');
        $this->assertTrue(auth()->check());
    }
}
