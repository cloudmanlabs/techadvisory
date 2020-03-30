<?php

namespace Tests\Browser\Nova;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AccentureTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group nova
     */
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

    /**
     * @group nova
     */
    public function testAccentureCanCreateAccenture()
    {
        $this->assertCount(0, User::all());

        $admin = factory(User::class)->states('accenture')->create();

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
        $this->assertCount(2, User::where('userType', 'accenture')->get());
    }
}
