<?php

namespace App\Providers;

use App\Nova\{GeneralInfoQuestion, GeneralInfoQuestionResponse, Accenture, Client, ClientProfileQuestion,ClientProfileQuestionResponse,VendorProfileQuestion,VendorProfileQuestionResponse,Practice,Project,SizingQuestion,SizingQuestionResponse,Subpractice,Vendor,User,VendorSolution,VendorSolutionQuestion,VendorSolutionQuestionResponse,SelectionCriteriaQuestion, SelectionCriteriaQuestionProjectPivot, SelectionCriteriaQuestionResponse, UserCredential, VendorApplication};

use App\Nova\Metrics\NumberOfAccentureUsers;
use App\Nova\Metrics\NumberOfClients;
use App\Nova\Metrics\NumberOfVendors;
use App\Nova\Metrics\TotalNumberOfUsers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Panel;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields(function () {
            return [
                new Panel('Videos', [
                    Text::make('Opening video', 'video_opening'),
                    Textarea::make('Opening video: Text', 'video_opening_text'),
                    Text::make('New project creation video', 'video_newProject'),
                    Textarea::make('New project creation video: Text', 'video_newProject_text'),
                    Text::make('Value targeting video', 'video_valueTargeting'),
                    Textarea::make('Value targeting video: Text', 'video_valueTargeting_text'),
                    Text::make('Vendor application', 'video_application'),
                    Textarea::make('Vendor application: Text', 'video_application_text'),
                    Text::make('Conclusions & recommendations', 'video_conclusions'),
                    Textarea::make('Conclusions & recommendations: Text', 'video_conclusions_text'),
                ]),
                new Panel('Accenture Texts', [
                    Textarea::make('Fitgap text', 'fitgap_description'),

                    Textarea::make('Home: Open Projects', 'accenture_Home_Open'),
                    Textarea::make('Home: Preparation Projects', 'accenture_Home_Preparation'),
                    Textarea::make('Home: Old Projects', 'accenture_Home_Old'),
                    Textarea::make('Home: Start new project', 'accenture_Home_StartNewProject'),

                    Textarea::make('Client List: List of Client', 'accenture_clientList_List'),
                    Textarea::make('Vendor List: List of Vendor', 'accenture_vendorList_List'),
                    Textarea::make('Vendor List: Vendors pending validation', 'accenture_vendorList_pendingEval'),
                    Textarea::make('Vendor List: Vendors pending validation', 'accenture_vendorList_pendingEval'),
                    Textarea::make('Vendor List: List of solutions', 'accenture_vendorList_solutions'),

                    Textarea::make('Project Analytics - From vendor side: Global Analysis & Analytics', 'accenture_analysisProjectVendor_title'),
                    Textarea::make('Project Analytics - From vendor side: Vendor Benchmarking', 'accenture_analysisProjectVendor_vendorBenchmarking'),
                    Textarea::make('Project Analytics - From client side: Global Analysis & Analytics', 'accenture_analysisProjectClient_title'),
                    Textarea::make('Project Analytics - From client side: Client Benchmarking', 'accenture_analysisProjectClient_clientBenchmarking'),
                    Textarea::make('Project Analytics - From historical side: Global Analysis & Analytics', 'accenture_analysisProjectHistorical_title'),
                    Textarea::make('Project Analytics - From historical side: Historical Benchmarking', 'accenture_analysisProjectHistorical_historicalBenchmarking'),
                    Textarea::make('Project Analytics - Custom searches: Global Analysis & Analytics', 'accenture_analysisProjectCustom_title'),
                    Textarea::make('Project Analytics - Custom searches: Other Queries', 'accenture_analysisProjectCustom_otherQueries'),
                    Textarea::make('Vendor Analytics - Graphs: Global Analysis & Analytics', 'accenture_analysisVendorGraphs_title'),
                    Textarea::make('Vendor Analytics - Graphs: Graphs', 'accenture_analysisVendorGraphs_graphs'),
                    Textarea::make('Vendor Analytics - Custom searches: Global Analysis & Analytics', 'accenture_analysisVendorCustom_title'),
                    Textarea::make('Vendor Analytics - Custom searches: Other Queries', 'accenture_analysisVendorCustom_otherQueries'),

                    Textarea::make('Client Profile View', 'accenture_clientProfileView_Title'),
                    Textarea::make('Client Profile Edit', 'accenture_clientProfileEdit_Title'),
                    Textarea::make('Vendor Profile View', 'accenture_vendorProfileView_Title'),
                    Textarea::make('Vendor Profile Edit', 'accenture_vendorProfileEdit_Title'),
                    Textarea::make('Vendor Validate Responses', 'accenture_vendorValidateResponses_title'),

                    Textarea::make('Vendor Proposal View', 'accenture_vendorProposalView_Title'),
                    Textarea::make('Vendor Proposal Edit', 'accenture_vendorProposalEdit_Title'),

                    Textarea::make('Vendor Solution View', 'accenture_vendorSolution_title'),
                    Textarea::make('Vendor Solution Edit', 'accenture_vendorSolutionEdit_title'),


                    Textarea::make('Project Home: Invited', 'accenture_projectHome_invited'),
                    Textarea::make('Project Home: Applicating', 'accenture_projectHome_applicating'),
                    Textarea::make('Project Home: Pending Evalutation', 'accenture_projectHome_pendingEvalutation'),
                    Textarea::make('Project Home: Release', 'accenture_projectHome_release'),
                    Textarea::make('Project Home: Released', 'accenture_projectHome_released'),
                    Textarea::make('Project Home: Disqualified', 'accenture_projectHome_disqualified'),
                    Textarea::make('Project Home: Rejected', 'accenture_projectHome_rejected'),

                    Textarea::make('Project Benchmark Overall: Overall Score', 'accenture_projectBenchmark_overallScore'),
                    Textarea::make('Project Benchmark Overall: Vendor score per criteria', 'accenture_projectBenchmark_vendorScore'),
                    Textarea::make('Project Benchmark Fitgap: Vendor Ranking by Fit Gap section', 'accenture_projectBenchmarkFitgap_ranking'),
                    Textarea::make('Project Benchmark Fitgap: Vendor comparison', 'accenture_projectBenchmarkFitgap_comparison'),
                    Textarea::make('Project Benchmark Vendor: Vendor Ranking by Vendor section', 'accenture_projectBenchmarkVendor_ranking'),
                    Textarea::make('Project Benchmark Vendor: Vendor comparison', 'accenture_projectBenchmarkVendor_comparison'),
                    Textarea::make('Project Benchmark Experience: Vendor Ranking by Experience section', 'accenture_projectBenchmarkExperience_ranking'),
                    Textarea::make('Project Benchmark Experience: Vendor comparison', 'accenture_projectBenchmarkExperience_comparison'),
                    Textarea::make('Project Benchmark Innovation: Vendor Ranking by Innovation section', 'accenture_projectBenchmarkInnovation_ranking'),
                    Textarea::make('Project Benchmark Innovation: Vendor comparison', 'accenture_projectBenchmarkInnovation_comparison'),
                    Textarea::make('Project Benchmark Implementation: Vendor Ranking by Implementation section', 'accenture_projectBenchmarkImplementation_ranking'),
                    Textarea::make('Project Benchmark Implementation: Vendor comparison', 'accenture_projectBenchmarkImplementation_comparison'),

                    Textarea::make('Project Value Targeting: Title', 'accenture_projectValueTargeting_Title'),
                    Textarea::make('Project Value Targeting: Selected Value Levers', 'accenture_projectValueTargeting_selected'),
                    Textarea::make('Project Value Targeting: Business Opportunity Details', 'accenture_projectValueTargeting_business'),
                    Textarea::make('Project Value Targeting: Conclusions', 'accenture_projectValueTargeting_conclusions'),
                    Textarea::make('Project Conclusions: Title', 'accenture_projectConclusions_title'),
                ]),
                new Panel('Client Texts', [
                    Textarea::make('Home: Open Projects', 'client_Home_Open'),
                    Textarea::make('Home: Preparation Projects', 'client_Home_Preparation'),
                    Textarea::make('Home: Old Projects', 'client_Home_Old'),

                    Textarea::make('First login registration: Timeline', 'client_firsLoginRegistration_timeline'),
                    Textarea::make('First login registration: Registration', 'client_firsLoginRegistration_registration'),
                    Textarea::make('First login registration: Complete your first project info', 'client_firsLoginRegistration_completeProjectInfo'),
                    Textarea::make('First login registration: Open project for vendors', 'client_firsLoginRegistration_OpenProject'),
                    Textarea::make('First login registration: Closure meeting', 'client_firsLoginRegistration_Closure'),

                    Textarea::make('Home profile create: Title', 'client_homeProfileCreate_title'),
                    Textarea::make('Profile: Title', 'client_profile_title'),


                    Textarea::make('Project Home: Invited', 'client_projectHome_invited'),
                    Textarea::make('Project Home: Released', 'client_projectHome_released'),

                    Textarea::make('Project Benchmark Overall: Overall Score', 'client_projectBenchmark_overallScore'),
                    Textarea::make('Project Benchmark Overall: Vendor score per criteria', 'client_projectBenchmark_vendorScore'),
                    Textarea::make('Project Benchmark Fitgap: Vendor Ranking by Fit Gap section', 'client_projectBenchmarkFitgap_ranking'),
                    Textarea::make('Project Benchmark Fitgap: Vendor comparison', 'client_projectBenchmarkFitgap_comparison'),
                    Textarea::make('Project Benchmark Vendor: Vendor Ranking by Vendor section', 'client_projectBenchmarkVendor_ranking'),
                    Textarea::make('Project Benchmark Vendor: Vendor comparison', 'client_projectBenchmarkVendor_comparison'),
                    Textarea::make('Project Benchmark Experience: Vendor Ranking by Experience section', 'client_projectBenchmarkExperience_ranking'),
                    Textarea::make('Project Benchmark Experience: Vendor comparison', 'client_projectBenchmarkExperience_comparison'),
                    Textarea::make('Project Benchmark Innovation: Vendor Ranking by Innovation section', 'client_projectBenchmarkInnovation_ranking'),
                    Textarea::make('Project Benchmark Innovation: Vendor comparison', 'client_projectBenchmarkInnovation_comparison'),
                    Textarea::make('Project Benchmark Implementation: Vendor Ranking by Implementation section', 'client_projectBenchmarkImplementation_ranking'),
                    Textarea::make('Project Benchmark Implementation: Vendor comparison', 'client_projectBenchmarkImplementation_comparison'),

                    Textarea::make('Project Value Targeting: Title', 'accenture_projectValueTargeting_Title'),
                    Textarea::make('Project Value Targeting: Selected Value Levers', 'accenture_projectValueTargeting_selected'),
                    Textarea::make('Project Value Targeting: Business Opportunity Details', 'accenture_projectValueTargeting_business'),
                    Textarea::make('Project Value Targeting: Conclusions', 'accenture_projectValueTargeting_conclusions'),
                    Textarea::make('Project Conclusions: Title', 'client_projectConclusions_title'),

                    Textarea::make('View Vendor Proposal: Title', 'client_viewVendorProposal_title'),
                ]),
                new Panel('Vendor Texts', [
                    Textarea::make('Home: Invitation Phase', 'vendor_Home_Invitation'),
                    Textarea::make('Home: Started Applications', 'vendor_Home_Started'),
                    Textarea::make('Home: Submitted Applications', 'vendor_Home_Submitted'),
                    Textarea::make('Home: Rejected Applications', 'vendor_Home_Rejected'),
                ])
            ];
        });
    }

    protected function resources()
    {
        $common = [
            Accenture::class,
            Client::class,
            Vendor::class,
            UserCredential::class,
            Practice::class,
            Subpractice::class,
            Project::class,
            VendorApplication::class,

            VendorSolution::class,

            GeneralInfoQuestion::class,
            GeneralInfoQuestionResponse::class,

            SizingQuestion::class,
            SizingQuestionResponse::class,

            SelectionCriteriaQuestion::class,
            SelectionCriteriaQuestionProjectPivot::class,
            SelectionCriteriaQuestionResponse::class,

            ClientProfileQuestion::class,
            ClientProfileQuestionResponse::class,

            VendorProfileQuestion::class,
            VendorProfileQuestionResponse::class,

            VendorSolutionQuestion::class,
            VendorSolutionQuestionResponse::class,
        ];

        if (auth()->user()->isAdmin()) {
            $other = [
                User::class,
            ];
        } else {
            $other = [];
        }

        Nova::resources(array_merge($common, $other));
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->isAdmin() || $user->isAccenture();
        });
    }

    /**
     * Configure the Nova authorization services.
     *
     * @return void
     */
    protected function authorization()
    {
        $this->gate();

        Nova::auth(function ($request) {
            return Gate::check('viewNova', [$request->user()]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new TotalNumberOfUsers,
            new NumberOfAccentureUsers,
            new NumberOfClients,
            new NumberOfVendors,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \OptimistDigital\NovaSettings\NovaSettings
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
