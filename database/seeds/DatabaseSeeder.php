<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);

        $this->call(PracticeSeeder::class);
        $this->call(SubpracticeSeeder::class);

        $this->call(GeneralInfoQuestionSeeder::class);

        $this->call(ProjectSeeder::class);
    }
}
