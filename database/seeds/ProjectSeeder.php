<?php

use App\Project;
use App\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Project::class, 6)->create();
        factory(Project::class, 4)->states(['open'])->create();
        factory(Project::class, 3)->states(['old'])->create();
    }
}
