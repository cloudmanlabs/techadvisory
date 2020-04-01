<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAttachProjects()
    {
        $client = factory(User::class)->states('client')->create();
        $projects = factory(Project::class, 5)->make();

        foreach ($projects as $key => $project) {
            $client->projectsClient()->save($project);
        }

        $this->assertCount(5, $client->projectsClient);
    }
}
