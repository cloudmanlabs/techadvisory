<?php

namespace Tests\Feature;

use App\Practice;
use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PracticeTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreatePractice()
    {
        $practice = new Practice([
            'name' => 'newName'
        ]);
        $practice->save();

        $this->assertCount(1, Practice::all());
    }

    public function testCanAttachProjects()
    {
        $practice = factory(Practice::class)->create();
        $projects = factory(Project::class, 5)->make();

        foreach ($projects as $key => $project) {
            $practice->projects()->save($project);
        }

        $this->assertCount(5, $practice->projects);
    }

    public function testCanGetNumberOfProjectsAVendorHasAppliedToWithThisPractice()
    {
        $practice1 = factory(Practice::class)->create();
        $practice2 = factory(Practice::class)->create();
        factory(Project::class, 5)->create([
            'practice_id' => $practice1->id
        ]);
        factory(Project::class, 3)->create([
            'practice_id' => $practice2->id
        ]);
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        foreach(Project::all() as $project){
            $vendor->applyToProject($project);
        }

        $this->assertCount(8, $vendor->vendorAppliedProjects()->get());

        $this->assertEquals(5, $practice1->numberOfProjectsByVendor($vendor));
        $this->assertEquals(3, $practice2->numberOfProjectsByVendor($vendor));
    }
}
