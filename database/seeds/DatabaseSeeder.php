<?php

use App\UserCredential;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
        $this->call(SelectionCriteriaQuestionSeeder::class);

        $this->call(ProjectSeeder::class);
        $this->call(VendorApplicationSeeder::class);

        $this->call(VendorSolutionQuestionSeeder::class);

        $this->call(SettingsSeeder::class);
    }
}
