<?php

namespace App\Providers;

use App\Nova\GeneralInfoQuestion;
use App\Nova\GeneralInfoQuestionResponse;
use App\Nova\Accenture;
use App\Nova\Client;
use App\Nova\ClientProfileQuestion;
use App\Nova\ClientProfileQuestionResponse;
use App\Nova\VendorProfileQuestion;
use App\Nova\VendorProfileQuestionResponse;
use App\Nova\Metrics\NumberOfAccentureUsers;
use App\Nova\Metrics\NumberOfClients;
use App\Nova\Metrics\NumberOfVendors;
use App\Nova\Metrics\TotalNumberOfUsers;
use App\Nova\Practice;
use App\Nova\Project;
use App\Nova\SizingQuestion;
use App\Nova\SizingQuestionResponse;
use App\Nova\Subpractice;
use App\Nova\Vendor;
use App\Nova\User;
use App\Nova\VendorSolution;
use App\Nova\VendorSolutionQuestion;
use App\Nova\VendorSolutionQuestionResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
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
                    Text::make('Accenture Home', 'accenture_Home'),
                    Text::make('Accenture New Project Set Up', 'accenture_NewProjectSetUp'),
                    Text::make('Accenture Value Targeting', 'accenture_ValueTargeting'),
                    Text::make('Accenture Conclusions', 'accenture_Conclusions'),

                    Text::make('Client Home', 'client_Home'),
                    Text::make('Client New Project Set Up', 'client_NewProjectSetUp'),
                    Text::make('Client Conclusions', 'client_Conclusions'),
                    Text::make('Client First Login', 'client_firstLogin'),
                    Text::make('Client Profile', 'client_Profile'),
                    Text::make('Client Profile Create', 'client_ProfileCreate'),

                    Text::make('Vendor First Login', 'vendor_firstLogin'),
                    Text::make('Vendor Home', 'vendor_Home'),
                    Text::make('Vendor Profile', 'vendor_Profile'),
                    Text::make('Vendor Profile Create', 'vendor_ProfileCreate'),
                    Text::make('Vendor New Application', 'vendor_NewApplication'),
                    Text::make('Vendor Solutions Home', 'vendor_SolutionsHome'),
                ]),
                new Panel('Texts', [
                    Text::make('Accenture Home Open Projects', 'accenture_Home_Open'),
                    Text::make('Accenture Home Preparation Projects', 'accenture_Home_Preparation'),
                    Text::make('Accenture Home Old Projects', 'accenture_Home_Old'),

                    Text::make('Client Home Open Projects', 'client_Home_Open'),
                    Text::make('Client Home Preparation Projects', 'client_Home_Preparation'),
                    Text::make('Client Home Old Projects', 'client_Home_Old'),

                    Text::make('Vendor Home Invitation Phase', 'vendor_Home_Invitation'),
                    Text::make('Vendor Home Started Applications', 'vendor_Home_Started'),
                    Text::make('Vendor Home Submitted Applications', 'vendor_Home_Submitted'),
                    Text::make('Vendor Home Rejected Applications', 'vendor_Home_Rejected'),
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
            Practice::class,
            Subpractice::class,
            Project::class,

            VendorSolution::class,

            GeneralInfoQuestion::class,
            GeneralInfoQuestionResponse::class,

            SizingQuestion::class,
            SizingQuestionResponse::class,

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
