<?php

namespace Tests\Feature\Views\Vendor;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreviewProject extends TestCase
{
    use RefreshDatabase;

    public function testPreviewWithoutProject()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/vendors/previewProject');

        $response->assertStatus(404);
    }

    public function testPreviewWithProjectAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/previewProject/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testPreviewWithProjectNotAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/previewProject/' . $project->id);

        $response->assertStatus(404);
    }
}
