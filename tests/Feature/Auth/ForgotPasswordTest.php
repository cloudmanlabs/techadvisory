<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordResetRouteExists()
    {
        $response = $this->get(route('password.request'));
        $response->assertOk();
    }

    public function testSendingForgotPasswordLinkWorks()
    {
        Notification::fake();

        Notification::assertNothingSent();



        $user = factory(User::class)->create([
            'email' => 'email@email.com',
        ]);
        $otherUser = factory(User::class)->create([
            'email' => 'other@email.com',
        ]);

        $response = $this
            ->from('password/reset')
            ->post('password/email', [
                'email' => 'email@email.com',
            ]);
        $response->assertStatus(302)
                ->assertSessionHas('status', 'We have emailed your password reset link!')
                ->assertRedirect('/password/reset');

        // Check email got sent
        Notification::assertSentTo($user, ResetPassword::class);
        Notification::assertNotSentTo($otherUser, ResetPassword::class);

        $notifications = Notification::sent($user, ResetPassword::class);
        $message = $notifications[0]->toMail($user);

        $this->assertStringContainsString('You are receiving this email because we received a password reset request for your account.', implode('', $message->introLines));
    }
}
