<?php

namespace Tests\Feature\Views\Accenture;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use ProjectSeeder;
use Tests\TestCase;

class AnalysisHistoricalTest extends TestCase
{
    use RefreshDatabase;

    public function testWorksWithoutProjects()
    {
        $user = factory(User::class)->states('accenture')->create();

        $response = $this
            ->actingAs($user)
            ->get('/accenture/analysis/historical');

        $response->assertStatus(200);
    }

    public function testWorksWithProjects()
    {
        $user = factory(User::class)->states('accenture')->create();

        $this->seed(ProjectSeeder::class);

        $response = $this
            ->actingAs($user)
            ->get('/accenture/analysis/historical');

        $response->assertStatus(200);
    }
}
