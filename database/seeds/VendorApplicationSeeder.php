<?php

use App\Project;
use App\User;
use Illuminate\Database\Seeder;

class VendorApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendor = User::where('email', 'vendor@vendor.com')->first();

        $projects = Project::all();

        foreach ($projects as $key => $project) {
            $application = $vendor->applyToProject($project);
            switch ($key % 4) {
                case 0:
                    break;
                case 1:
                    $application->setApplicating();
                    break;
                case 2:
                    $application->setSubmitted();
                    break;
                case 3:
                    $application->setRejected();
                    break;
            }
        }
    }
}
