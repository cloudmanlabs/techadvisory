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
                    Textarea::make('Accenture Home: Open Projects', 'accenture_Home_Open'),
                    Textarea::make('Accenture Home: Preparation Projects', 'accenture_Home_Preparation'),
                    Textarea::make('Accenture Home: Old Projects', 'accenture_Home_Old'),
                    Textarea::make('Accenture Home: Start new project', 'accenture_Home_StartNewProject'),

                    Textarea::make('Accenture Client List: List of Client', 'accenture_clientList_List'),
                    Textarea::make('Accenture Vendor List: List of Vendor', 'accenture_vendorList_List'),
                    Textarea::make('Accenture Vendor List: Vendors pending validation', 'accenture_vendorList_pendingEval'),
                    Textarea::make('Accenture Vendor List: Vendors pending validation', 'accenture_vendorList_pendingEval'),
                    Textarea::make('Accenture Vendor List: List of solutions', 'accenture_vendorList_solutions'),

                    Textarea::make('Accenture Analytics - From vendor side: Global Analysis & Analytics', 'accenture_analysisProjectVendor_title'),
                    Textarea::make('Accenture Analytics - From vendor side: Vendor Benchmarking', 'accenture_analysisProjectVendor_vendorBenchmarking'),
                    Textarea::make('Accenture Analytics - From client side: Global Analysis & Analytics', 'accenture_analysisProjectClient_title'),
                    Textarea::make('Accenture Analytics - From client side: Client Benchmarking', 'accenture_analysisProjectClient_clientBenchmarking'),
                    Textarea::make('Accenture Analytics - From historical side: Global Analysis & Analytics', 'accenture_analysisProjectHistorical_title'),
                    Textarea::make('Accenture Analytics - From historical side: Historical Benchmarking', 'accenture_analysisProjectHistorical_historicalBenchmarking'),
                    Textarea::make('Accenture Analytics - Custom searches: Global Analysis & Analytics', 'accenture_analysisProjectCustom_title'),
                    Textarea::make('Accenture Analytics - Custom searches: Other Queries', 'accenture_analysisProjectCustom_otherQueries'),
                ]),
                new Panel('Client Texts', [
                    Textarea::make('Client Home: Open Projects', 'client_Home_Open'),
                    Textarea::make('Client Home: Preparation Projects', 'client_Home_Preparation'),
                    Textarea::make('Client Home: Old Projects', 'client_Home_Old'),
                ]),
                new Panel('Vendor Texts', [
                    Textarea::make('Vendor Home: Invitation Phase', 'vendor_Home_Invitation'),
                    Textarea::make('Vendor Home: Started Applications', 'vendor_Home_Started'),
                    Textarea::make('Vendor Home: Submitted Applications', 'vendor_Home_Submitted'),
                    Textarea::make('Vendor Home: Rejected Applications', 'vendor_Home_Rejected'),
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
