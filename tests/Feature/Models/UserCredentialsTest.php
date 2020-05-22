<?php

namespace Tests\Feature\Models;

use App\Mail\CredentialResetPasswordMail;
use App\Mail\NewCredentialMail;
use App\User;
use App\UserCredential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class UserCredentialsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateCredentials()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com',
            'password' => 'password',

            'user_id' => $user->id
        ]);
        $credential->save();

        $this->assertCount(1, $user->credentials);
    }

    public function testCanCreateHiddenCredential()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        $credential = new UserCredential([
            'name' => 'nameeee',
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
        Mail::fake();

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
        Mail::fake();

        $user = factory(User::class)->states('client')->create();
        $user->credentials()->save(new UserCredential([
            'name' => 'nameeee',
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
        Mail::fake();

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
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();
        $user->credentials()->save(new UserCredential([
            'name' => 'nameeee',
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

    public function testCanGeneratePasswordChangeToken()
    {
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();

        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com'
        ]);
        $user->credentials()->save($credential);

        // Set it to null, because observer sets a token and sends the email
        $credential->passwordChangeToken = null;
        $credential->save();

        $this->assertNull($credential->passwordChangeToken);

        $credential->setPasswordChangeToken();

        $credential->refresh();
        $this->assertNotNull($credential->passwordChangeToken);
    }


    public function testCreatingACredentialSendsAnEmailToTheAddress()
    {
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();
        $user->credentials()->save(new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]));

        Mail::assertSent(NewCredentialMail::class, function ($mail) use ($user) {
            return $mail->hasTo('test@test.com');
        });
    }

    public function testChangePasswordRouteGives404WithoutToken()
    {
        $response = $this->get('/changePassword');

        $response->assertStatus(404);
    }

    public function testChangePasswordRouteGives404WithWrongToken()
    {
        $response = $this->get('/changePassword/hey');

        $response->assertStatus(404);
    }

    public function testChangePasswordRouteWorksWithToken()
    {
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();
        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com'
        ]);
        $user->credentials()->save($credential);


        $response = $this->get('/changePassword/'. $credential->passwordChangeToken);

        $response->assertOk();
    }

    public function testChangePasswordPostGives404WithoutToken()
    {
        $response = $this->post('/changePassword');

        $response->assertStatus(404);
    }

    public function testChangePasswordPostGives404WithWrongToken()
    {
        $response = $this->post('/changePassword/hello');

        $response->assertStatus(404);
    }

    public function testCanChangePasswordWithPost()
    {
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();
        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com'
        ]);
        $user->credentials()->save($credential);

        $response = $this->post('/changePassword/' . $credential->passwordChangeToken, [
            'password' => 'this is my new password m8',
            'password_confirmation' => 'this is my new password m8',
        ]);

        $response->assertRedirect('/');

        $credential->refresh();
        $this->assertTrue(Hash::check('this is my new password m8', $credential->password));
        $this->assertNull($credential->passwordChangeToken);
    }

    public function testCanGetEnterEmailView()
    {
        $response = $this->get('/enterEmail');

        $response->assertOk();
    }

    public function testEnteringEmailSendsPasswordResetLink()
    {
        Mail::fake();

        $user = factory(User::class)->states('vendor')->create();
        $user->credentials()->save(new UserCredential([
            'name' => 'nameeee',
            'email' => 'test@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]));

        $response = $this
            ->from('/enterEmail')
            ->post('/enterEmail/', [
                'email' => 'test@test.com',
            ]);
        $response->assertRedirect('/enterEmail');

        Mail::assertSent(CredentialResetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo('test@test.com');
        });
    }
}
