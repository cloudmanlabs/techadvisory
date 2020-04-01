<?php

namespace Tests\Feature;

use App\Practice;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeederWorks()
    {
        $this->seed();



        $this->assertDatabaseHas('users', [
            'email' => 'admin@admin.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'accenture@accenture.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'client@client.com',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'vendor@vendor.com',
        ]);

        $this->assertGreaterThan(0, Practice::count());
        $this->assertGreaterThan(0, Project::count());
    }
}
