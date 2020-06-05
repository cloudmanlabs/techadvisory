<?php

namespace Tests\Feature;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PracticeSeeder;
use ProjectSeeder;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeederWorks()
    {
        $this->seed();

        $this->assertGreaterThan(3, User::count());
        $this->assertGreaterThan(0, Practice::count());
        $this->assertGreaterThan(0, Project::count());
    }

    public function testProjectSeederWorksAlone()
    {
        $this->seed(ProjectSeeder::class);

        $this->assertGreaterThan(0, Project::count());
    }

    public function testPracticeSeederWorksAlone()
    {
        $this->seed(PracticeSeeder::class);

        $this->assertGreaterThan(0, Practice::count());
    }
}
