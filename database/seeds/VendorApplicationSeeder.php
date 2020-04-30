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
        $vendors = User::vendorUsers()->where('hasFinishedSetUp',true)->get();
        $projects = Project::all();

        foreach ($projects as $key1 => $project) {
            foreach ($vendors as $key2 => $vendor) {
                if(random_int(0, 10) > 5){
                    continue;
                }
                $application = $vendor->applyToProject($project);
                switch (($key1 + $key2 + 2) % 7) {
                    case 0:
                        // Invited
                        break;
                    case 1:
                        $application->setApplicating();
                        break;
                    case 2:
                        $application->setPendingEvaluation();
                        break;
                    case 3:
                        $application->setEvaluated();
                        break;
                    case 4:
                        $application->setSubmitted();
                        break;
                    case 5:
                        $application->setDisqualified();
                        break;
                    case 6:
                        $application->setRejected();
                        break;
                }
            }
        }
    }
}
