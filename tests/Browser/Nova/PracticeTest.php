<?php

namespace Tests\Browser\Nova;

use App\Practice;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PracticeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group nova
     */
    public function testAdminCanCreatePractice()
    {
        $this->assertCount(0, Practice::all());

        $admin = factory(User::class)->states('admin')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/practices/new')
                ->pause(500)
                ->type('@name', 'practiceName')
                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/practices');
        });

        $this->assertCount(1, Practice::all());
    }

    /**
     * @group nova
     */
    public function testAccentureCanCreatePractice()
    {
        $this->assertCount(0, Practice::all());

        $admin = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/practices/new')
                ->pause(500)
                ->type('@name', 'practiceName')
                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/practices');
        });

        $this->assertCount(1, Practice::all());
    }
}
