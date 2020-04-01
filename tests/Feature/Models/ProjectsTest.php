<?php

namespace Tests\Feature;

use App\Folder;
use App\Practice;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateProject()
    {
        $this->assertCount(0, Project::all());

        factory(Practice::class)->create();

        $project = new Project([
            'name' => 'New Project',
            'hasOrals' => false,
            'hasValueTargeting' => false,

            'progressSetUp' => 20,
            'progressValue' => 10,
            'progressResponse' => 0,
            'progressAnalytics' => 0,
            'progressConclusions' => 0,

            'currentPhase' => 'open',

            'deadline' => Carbon::now()
                                ->addMonth()
                                ->addWeek()
                                ->toDateTimeString(),

            'practice_id' => 1,
            'client_id' => 1,
        ]);
        $project->save();

        $this->assertCount(1, Project::all());
    }

    public function testProjectDefaultPhaseIsPreparation()
    {
        $this->assertCount(0, Project::all());

        factory(Practice::class)->create();

        $project = new Project([
            'name' => 'New Project',
            'hasOrals' => false,
            'hasValueTargeting' => false,

            'deadline' => Carbon::now()
                ->addMonth()
                ->addWeek()
                ->toDateTimeString(),

            'practice_id' => 1,
            'client_id' => 1,
        ]);
        $project->save();

        $this->assertCount(1, Project::preparationProjects()->get());
        $this->assertCount(0, Project::openProjects()->get());
        $this->assertCount(0, Project::oldProjects()->get());
    }

    public function testCanAddFoldersToProject()
    {
        $folder = Folder::createNewRandomFolder();
        $folder1 = Folder::createNewRandomFolder();
        $folder2 = Folder::createNewRandomFolder();
        $folder3 = Folder::createNewRandomFolder();

        factory(Practice::class)
            ->create()
            ->each(function ($practice) {
                $practice->projects()->save(factory(Project::class)->states(['withClient'])->make());
            });
        $project = Project::first();

        $this->assertNull($project->conclusionsFolder);
        $this->assertNull($project->selectedValueLeversFolder);
        $this->assertNull($project->businessOpportunityFolder);
        $this->assertNull($project->vtConclusionsFolder);

        $project->conclusionsFolder = $folder;
        $project->selectedValueLeversFolder = $folder1;
        $project->businessOpportunityFolder = $folder2;
        $project->vtConclusionsFolder = $folder3;

        $this->assertNotNull($project->conclusionsFolder);
        $this->assertNotNull($project->selectedValueLeversFolder);
        $this->assertNotNull($project->businessOpportunityFolder);
        $this->assertNotNull($project->vtConclusionsFolder);
    }

    // public function testCanAddVendorsToProject()
    // {
    //     $project = factory(Project::class)->create();

    //     $vendors = factory(Vendor::class, 5)->create();

    //     foreach ($vendors as $key => $vendor) {
    //         $project->vendors()->syncWithoutDetaching([$vendor->id]);
    //     }

    //     $this->assertCount(5, $project->vendors);
    // }

    public function testCanAddPracticesToProject()
    {
        $practice = factory(Practice::class)->create();

        $project = factory(Project::class)->states(['withClient'])->make();

        $this->assertNull($project->practice);

        $project->practice()->associate($practice);
        $project->save();

        $this->assertNotNull($project->practice);
    }

    public function testCanAddClientToProject()
    {
        $client = factory(User::class)->states('client')->create();

        $project = factory(Project::class)->states(['withPractice'])->make();

        $this->assertNull($project->client);

        $project->client()->associate($client);
        $project->save();

        $this->assertNotNull($project->client);
    }
}
