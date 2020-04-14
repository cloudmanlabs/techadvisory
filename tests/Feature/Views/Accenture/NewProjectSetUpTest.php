<?php

namespace Tests\Feature\Views\Accenture;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewProjectSetUpTest extends TestCase
{
    use RefreshDatabase;

    public function testNewProjectSetUpWorksWithEmptyProject()
    {
        $project = new Project();
        $project->save();

        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/newProjectSetUp/'. $project->id);

        $response->assertStatus(200);
    }
}
