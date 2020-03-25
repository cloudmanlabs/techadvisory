<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
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

    public function testAdminCanCreateAccenture()
    {
        $this->assertCount(0, User::all());

        $admin = factory(User::class)->states('admin')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/accentures/new')
                ->pause(500)
                ->type('@name', 'name')
                ->type('@email', 'email@email.com')
                ->type('@password', 'password')
                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/accentures');
        });

        $this->assertCount(2, User::all());
        $this->assertCount(1, User::where('userType', 'accenture')->get());
    }
}
