<?php

namespace Tests\Feature\Models;

use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubpracticeTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateSubpractice()
    {
        $practice = factory(Practice::class)->create();

        $subpractice = new Subpractice([
            'name' => 'newName',
            'practice_id' => $practice->id
        ]);
        $subpractice->save();

        $this->assertCount(1, Subpractice::all());
    }

    public function testCanAttachProjects()
    {
        $subpractice = factory(Subpractice::class)->create();
        $projects = factory(Project::class, 5)->create();

        foreach ($projects as $key => $project) {
            $subpractice->projects()->attach($project);
        }

        $this->assertCount(5, $subpractice->projects);
    }
}
