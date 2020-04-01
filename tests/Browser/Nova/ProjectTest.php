<?php

namespace Tests\Browser\Nova;

use App\Practice;
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
        factory(Practice::class, 5)->create();
        factory(User::class, 4)
            ->states('client')
            ->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@deadline', '2020-04-18 12:00:00') // This is first cause otherwise the popup remains open and we can't click anything else
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')
                ->select('@client') // Select a random client
                ->select('@practice')

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
        factory(Practice::class, 5)->create();
        factory(User::class, 4)
            ->states('client')
            ->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@deadline', '2020-04-18 12:00:00')
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')
                ->select('@client') // Select a random client
                ->select('@practice')

                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/projects');
        });

        $this->assertCount(1, Project::all());
    }

    /**
     * @group nova
     */
    public function testCanNotCreateProjectWithoutClient()
    {
        $this->assertCount(0, Project::all());

        $admin = factory(User::class)->states('accenture')->create();
        factory(Practice::class, 5)->create();
        factory(User::class, 4)
            ->states('client')
            ->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@deadline', '2020-04-18 12:00:00')
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')
                ->select('@practice')

                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/projects/new');
        });

        $this->assertCount(0, Project::all());
    }

    /**
     * @group nova
     */
    public function testCanNotCreateProjectWithoutPractice()
    {
        $this->assertCount(0, Project::all());

        $admin = factory(User::class)->states('accenture')->create();
        factory(Practice::class, 5)->create();
        factory(User::class, 4)
            ->states('client')
            ->create();

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/resources/projects/new')
                ->pause(500)
                ->type('@deadline', '2020-04-18 12:00:00')
                ->type('@name', 'practiceName')
                ->check('Orals')
                ->check('Value Targeting')
                ->select('@client')

                ->press('@create-button')
                ->pause(500)
                ->assertPathBeginsWith('/admin/resources/projects/new');
        });

        $this->assertCount(0, Project::all());
    }
}
