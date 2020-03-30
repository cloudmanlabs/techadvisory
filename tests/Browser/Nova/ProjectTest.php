<?php

namespace Tests\Browser\Nova;

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProjectTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @group nova
     */
    public function testAdminCanCreateProject()
    {
        $this->assertCount(0, Project::all());

        $admin = factory(User::class)->states('admin')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')

                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/projects');
        });

        $this->assertCount(1, Project::all());
    }

    /**
     * @group nova
     */
    public function testAccentureCanCreateProject()
    {
        $this->assertCount(0, Project::all());

        $admin = factory(User::class)->states('accenture')->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')

                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/projects');
        });

        $this->assertCount(1, Project::all());
    }
}
