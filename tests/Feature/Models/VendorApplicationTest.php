<?php

namespace Tests\Feature\Models;

use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateApplication()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $application = new VendorApplication([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ]);
        $application->save();

        $this->assertCount(1, VendorApplication::all());
    }

    public function testVendorCanApplyToProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $application = $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());
        $this->assertNotNull($application);
    }

    public function testVendorApplyingToProjectTwiceDoesntCreateAnotherApplication()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, VendorApplication::all());

        $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());

        $vendor->applyToProject($project);
        $this->assertCount(1, VendorApplication::all());
    }

    public function testAccentureAndClientsCanNotApplyToProjects()
    {
        $project = factory(Project::class)->create();
        $accenture = factory(User::class)->states(['accenture', 'finishedSetup'])->create();
        $client = factory(User::class)->states(['client', 'finishedSetup'])->create();

        $accApplication = $accenture->applyToProject($project);
        $clientApplication = $client->applyToProject($project);

        $this->assertCount(0, VendorApplication::all());
        $this->assertNull($accApplication);
        $this->assertNull($clientApplication);
    }

    public function testAVendorThatHasntFinishedSetupCanNotApply()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor'])->create();

        $this->assertCount(0, VendorApplication::all());

        $application = $vendor->applyToProject($project);
        $this->assertCount(0, VendorApplication::all());
        $this->assertNull($application);
    }

    public function testCanGetTheProjectsAVendorHasAppliedTo()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $application = $vendor->applyToProject($project);


    }
}
