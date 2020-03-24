<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewsTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testWelcomeWorks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('You are not logged in');
        });
    }

    public function testAccentureCanLoginInToAccenture()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/accenture/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/accenture/home');
        });
    }

    public function testAccentureCanNotLoginInToClientAndVendor()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/client/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/client/login')
                ->assertSee('please use your corresponding login page');

            $browser->visit('/vendors/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/vendors/login')
                ->assertSee('please use your corresponding login page');
        });
    }

    public function testClientCanLoginInToClient()
    {
        $user = factory(User::class)->states('client')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/client/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/client/home');
        });
    }

    public function testClientCanNotLoginInToAccentureAndVendor()
    {
        $user = factory(User::class)->states('client')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/accenture/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/accenture/login')
                ->assertSee('please use your corresponding login page');

            $browser->visit('/vendors/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/vendors/login')
                ->assertSee('please use your corresponding login page');
        });
    }

    public function testVendorCanLoginInToVendor()
    {
        $user = factory(User::class)->states('vendor')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/vendors/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/vendors/home');
        });
    }

    public function testVendorCanNotLoginInToAccentureAndClient()
    {
        $user = factory(User::class)->states('vendor')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/accenture/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/accenture/login')
                ->assertSee('please use your corresponding login page');

            $browser->visit('/client/login')
                ->assertSee('Email address')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/client/login')
                ->assertSee('please use your corresponding login page');
        });
    }
}
