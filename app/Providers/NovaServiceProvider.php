<?php

namespace App\Providers;

use App\Nova\GeneralInfoQuestion;
use App\Nova\GeneralInfoQuestionResponse;
use App\Nova\Accenture;
use App\Nova\Client;
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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

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

            GeneralInfoQuestion::class,
            GeneralInfoQuestionResponse::class,

            SizingQuestion::class,
            SizingQuestionResponse::class,
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
        return [];
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
