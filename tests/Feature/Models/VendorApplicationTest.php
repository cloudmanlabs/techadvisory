<?php

namespace Tests\Feature\Models;

use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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

        $this->assertCount(0, $vendor->vendorAppliedProjects()->get());

        $vendor->applyToProject($project);

        $this->assertCount(1, $vendor->vendorAppliedProjects()->get());
    }

    public function testCanGetThevendorsAppliedToAProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $this->assertCount(0, $project->vendorsApplied()->get());

        $vendor->applyToProject($project);

        $this->assertCount(1, $project->vendorsApplied()->get());
    }

    public function testApplicationHasPhase()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $this->assertNotNull($application->phase);
    }

    public function testApplicationDefaultsToInvitationPhase()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $this->assertEquals('invitation',$application->phase);
    }

    public function testCanSetApplicationAsStarted()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application->setStarted();

        $this->assertEquals('started', $application->phase);
    }

    public function testCanSetApplicationAsSubmitted()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application->setSubmitted();

        $this->assertEquals('submitted', $application->phase);
    }

    public function testCanSetApplicationAsRejected()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application->setRejected();

        $this->assertEquals('rejected', $application->phase);
    }

    public function testChainingSetsOnlySetsTheLastOne()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $application
                ->setStarted()
                ->setSubmitted()
                ->setRejected();

        $this->assertEquals('rejected', $application->phase);
    }

    public function testVendorCanRejectProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
                    ->post('vendors/application/setRejected/'.$project->id);
        $response->assertRedirect('vendors/home');

        $application->refresh();
        $this->assertEquals('rejected', $application->phase);
    }

    public function testVendorCanAcceptProject()
    {
        $project = factory(Project::class)->create();
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $application = $vendor->applyToProject($project);

        $response = $this->actingAs($vendor)
            ->post('vendors/application/setAccepted/' . $project->id);
        $response->assertRedirect('vendors/home');

        $application->refresh();
        $this->assertEquals('started', $application->phase);
    }
}
