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
        // Remove all folders
        Storage::disk('public')->deleteDirectory('folders');

        $this->call(ClientProfileQuestionSeeder::class);
        $this->call(VendorProfileQuestionSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(PracticeSeeder::class);
        $this->call(SubpracticeSeeder::class);

        $this->call(GeneralInfoQuestionSeeder::class);
        $this->call(SizingQuestionSeeder::class);

        $this->call(ProjectSeeder::class);
    }
}
