<?php

namespace Tests\Feature;

use App\Folder;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateProject()
    {
        $this->assertCount(0, Project::all());

        $project = new Project([
            'name' => 'New Project',
            'hasOrals' => false,
            'hasValueTargeting' => false,

            'progressSetUp' => 20,
            'progressValue' => 10,
            'progressResponse' => 0,
            'progressAnalytics' => 0,
            'progressConclusions' => 0,
        ]);
        $project->save();

        $this->assertCount(1, Project::all());
    }

    public function testCanAddFoldersToProject()
    {
        $folder = Folder::createNewRandomFolder();
        $folder1 = Folder::createNewRandomFolder();
        $folder2 = Folder::createNewRandomFolder();
        $folder3 = Folder::createNewRandomFolder();

        $project = factory(Project::class)->create();

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
        $practices = factory(Practice::class, 5)->create();

        $project = factory(Project::class)->create();

        $project->practices()->syncWithoutDetaching($practices->pluck('id'));

        $this->assertCount(5, $project->practices);
    }
}
