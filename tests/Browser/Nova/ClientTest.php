<?php

namespace Tests\Browser\Nova;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ClientTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group nova
     */
    public function testAdminCanCreateClient()
    {
        $this->assertCount(0, User::all());

        $admin = factory(User::class)->states('admin')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/clients/new')
                ->pause(500)
                ->type('@name', 'name')
                ->type('@email', 'email@email.com')
                ->type('@password', 'password')
                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/clients');
        });

        $this->assertCount(2, User::all());
        $this->assertCount(1, User::where('userType', 'client')->get());
    }

    /**
     * @group nova
     */
    public function testAceentureCanCreateClient()
    {
        $this->assertCount(0, User::all());

        $admin = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/clients/new')
                ->pause(500)
                ->type('@name', 'name')
                ->type('@email', 'email@email.com')
                ->type('@password', 'password')
                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/clients');
        });

        $this->assertCount(2, User::all());
        $this->assertCount(1, User::where('userType', 'client')->get());
    }
}
