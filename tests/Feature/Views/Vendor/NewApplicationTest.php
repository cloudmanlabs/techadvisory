<?php

namespace Tests\Feature\Views\Vendor;

use App\GeneralInfoQuestion;
use App\Practice;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SizingQuestion;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewApplication extends TestCase
{
    use RefreshDatabase;

    public function testWithoutProject()
    {
        $user = factory(User::class)->states(['vendor', 'finishedSetup'])->create();

        $response = $this
            ->actingAs($user)
            ->get('/vendors/newApplication');

        $response->assertStatus(404);
    }

    public function testWithProjectAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $this->withoutExceptionHandling();
        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testWithProjectNotAppliedTo()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/' . $project->id);

        $response->assertStatus(404);
    }

    public function testGeneralInfoQuestionsWork()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }

    public function testSizingQuestionsWork()
    {
        $vendor = factory(User::class)->states(['vendor', 'finishedSetup'])->create();
        $question = factory(GeneralInfoQuestion::class)->create();
        $project = factory(Project::class)->create();
        $vendor->applyToProject($project);

        $response = $this
            ->actingAs($vendor)
            ->get('/vendors/newApplication/' . $project->id);

        $response->assertStatus(200)
            ->assertSee($question->label);
    }
}
