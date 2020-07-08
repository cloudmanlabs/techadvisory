<?php

namespace App\Observers;

use App\ClientProfileQuestionResponse;
use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionProjectPivot;
use App\SelectionCriteriaQuestionResponse;
use App\SizingQuestion;
use App\SizingQuestionResponse;
use Carbon\Carbon;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Support\Facades\Log;

class ProjectObserver
{
    public function creating(Project $project)
    {
        if($project->scoringValues == null){
            $project->scoringValues = [4, 4, 4, 4, 4];
        }

        if ($project->deadline == null) {
            $project->deadline = Carbon::now()->addYear();
        }

        if($project->fitgapWeightMust == null){
            $project->fitgapWeightMust = 10;
        }
        if($project->fitgapWeightRequired == null){
            $project->fitgapWeightRequired = 5;
        }
        if($project->fitgapWeightNiceToHave == null){
            $project->fitgapWeightNiceToHave = 1;
        }
        if($project->fitgapWeightFullySupports == null){
            $project->fitgapWeightFullySupports = 3;
        }
        if($project->fitgapWeightPartiallySupports == null){
            $project->fitgapWeightPartiallySupports = 2;
        }
        if($project->fitgapWeightPlanned == null){
            $project->fitgapWeightPlanned = 1;
        }

        if($project->fitgapFunctionalWeight == null){
            $project->fitgapFunctionalWeight = 60;
        }
        if($project->fitgapTechnicalWeight == null){
            $project->fitgapTechnicalWeight = 20;
        }
        if($project->fitgapServiceWeight == null){
            $project->fitgapServiceWeight = 10;
        }
        if($project->fitgapOthersWeight == null){
            $project->fitgapOthersWeight = 10;
        }

        if ($project->implementationImplementationWeight == null) {
            $project->implementationImplementationWeight = 20;
        }
        if ($project->implementationRunWeight == null) {
            $project->implementationRunWeight = 80;
        }

        // Default fitgap
        $project->fitgap5Columns = $project->fitgap5Columns ?? [
            [
                "Requirement Type" => "Functional",
                "Level 1" => "Transportation",
                "Level 2" => "Transport planning",
                "Level 3" => "Optimization",
                "Requirement" => "Requierement 1",
            ],
            [
                "Requirement Type" => "Functional",
                "Level 1" => "Transportation",
                "Level 2" => "Order management",
                "Level 3" => "Input",
                "Requirement" => "Requierement 2",
            ],
            [
                "Requirement Type" => "Functional",
                "Level 1" => "Transportation",
                "Level 2" => "Tendering & Spot Buying",
                "Level 3" => "Tendering",
                "Requirement" => "Requierement 3",
            ],
            [
                "Requirement Type" => "Functional",
                "Level 1" => "Transportation",
                "Level 2" => "Executuin & Visbility",
                "Level 3" => "Real time track & trace",
                "Requirement" => "Requierement 4",
            ],
            [
                "Requirement Type" => "Technical",
                "Level 1" => "IT",
                "Level 2" => "Administration",
                "Level 3" => "Users",
                "Requirement" => "Requierement 5",
            ],
            [
                "Requirement Type" => "Technical",
                "Level 1" => "IT",
                "Level 2" => "Architecture",
                "Level 3" => "Servers location",
                "Requirement" => "Requierement 6",
            ],
            [
                "Requirement Type" => "Technical",
                "Level 1" => "IT",
                "Level 2" => "Integration",
                "Level 3" => "Integration",
                "Requirement" => "Requierement 7",
            ],
            [
                "Requirement Type" => "Service",
                "Level 1" => "General",
                "Level 2" => "Education & Training",
                "Level 3" => "Resources",
                "Requirement" => "Requierement 8",
            ],
            [
                "Requirement Type" => "Service",
                "Level 1" => "General",
                "Level 2" => "Maintenance Support",
                "Level 3" => "Application updates",
                "Requirement" => "Requierement 9",
            ],
            [
                "Requirement Type" => "Service",
                "Level 1" => "General",
                "Level 2" => "Education & Training",
                "Level 3" => "Training",
                "Requirement" => "Requierement 10",
            ],
            [
                "Requirement Type" => "Others",
                "Level 1" => "General",
                "Level 2" => "Other",
                "Level 3" => "Training",
                "Requirement" => "Requierement 11",
            ],
            [
                "Requirement Type" => "Others",
                "Level 1" => "General",
                "Level 2" => "Other",
                "Level 3" => "Training",
                "Requirement" => "Requierement 12",
            ]
        ];

        $clientFitgap = [];
        foreach ($project->fitgap5Columns as $key => $value) {
            $clientFitgap[] = [
                'Client' => '',
                'Business Opportunity' => '',
            ];
        }
        $project->fitgapClientColumns = $project->fitgapClientColumns ?? $clientFitgap;
    }

    public function created(Project $project)
    {
        // Add all GeneralInfoQuestions by default
        foreach (GeneralInfoQuestion::all() as $key => $question) {
            $response = new GeneralInfoQuestionResponse([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }

        // Add all SizingQuestions by default
        foreach (SizingQuestion::all() as $key => $question) {
            $response = new SizingQuestionResponse([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }

        foreach (SelectionCriteriaQuestion::all() as $key2 => $question) {
            $response = new SelectionCriteriaQuestionProjectPivot([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }

        // Create all the folders
        $project->conclusionsFolder()->save(Folder::createNewRandomFolder('conclusions'));
        $project->selectedValueLeversFolder()->save(Folder::createNewRandomFolder('selectedValueLevers'));
        $project->businessOpportunityFolder()->save(Folder::createNewRandomFolder('businessOpportunity'));
        $project->vtConclusionsFolder()->save(Folder::createNewRandomFolder('vtConclusions'));
        $project->rfpFolder()->save(Folder::createNewRandomFolder('rfp'));
    }

    public function saving(Project $project)
    {
        if(! $project->step3SubmittedAccenture){
            $project->step3SubmittedClient = false;
        }
        if(! $project->step4SubmittedAccenture){
            $project->step4SubmittedClient = false;
        }

        // If client changed, update general info questions
        if($project->getOriginal('client_id') != $project->client_id){
            $responses = $project->generalInfoQuestions;
            $client = $project->client;
            if($client == null) return;

            foreach ($responses as $key => $response) {
                if(
                    $response->response != null
                    && $response->response != ""
                    && $response->response != "[]"
                ) {
                    continue;
                }
                /** @var GeneralInfoQuestionResponse $response */
                $related = $response->originalQuestion->clientProfileQuestion;

                if($related != null){
                    /** @var ClientProfileQuestionResponse|null $clientResponse */
                    $clientResponse = ClientProfileQuestionResponse::where('client_id', $client->id)
                        ->where('question_id', $related->id)
                        ->first();
                    if($clientResponse != null){
                        $response->response = $clientResponse->response;
                        $response->save();
                    }
                }
            }
        }
    }

    // public function deleting(Project $project)
    // {
    //     foreach ($project->generalInfoQuestions as $key => $question) {
    //         $question->delete();
    //     }
    // }
}
