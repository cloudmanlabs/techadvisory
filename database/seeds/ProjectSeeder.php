<?php

use App\Project;
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
        factory(Project::class, 6)->states(['withClient', 'withPractice', 'preparation'])->create();
        factory(Project::class, 4)->states(['withClient', 'withPractice', 'open'])->create();
        factory(Project::class, 3)->states(['withClient', 'withPractice', 'old'])->create();
    }
}
