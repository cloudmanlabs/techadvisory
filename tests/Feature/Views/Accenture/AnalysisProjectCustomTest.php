<?php

namespace Tests\Feature\Views\Accenture;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use ProjectSeeder;
use Tests\TestCase;

class AnalysisProjectCustomTest extends TestCase
{
    use RefreshDatabase;

    public function testWorksWithoutProjects()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/analysis/project/custom');

        $response->assertStatus(200);
    }

    public function testWorksWithProjects()
    {
        $this->seed(ProjectSeeder::class);

        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/analysis/project/custom');

        $response->assertStatus(200);
    }
}
