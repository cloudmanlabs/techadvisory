<?php

namespace Tests\Feature;

use App\Practice;
use App\Project;
use App\User;
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

    public function testCanAttachProject()
    {
        $practice = factory(Practice::class)->create();
        $projects = factory(Project::class, 5)->make();

        foreach ($projects as $key => $project) {
            $practice->projects()->save($project);
        }

        $this->assertCount(5, $practice->projects);
    }
}
