<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NovaTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAdminCanLogin()
    {
        $user = factory(User::class)->states('admin')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/admin/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/admin/dashboards/main');
        });
    }

    public function testAccentureCanLogin()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/admin/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/admin/dashboards/main');
        });
    }
}
