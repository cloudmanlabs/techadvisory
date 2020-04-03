<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::prefix('client')
    ->name('client.')
    ->namespace('Client')
    ->group(function () {
        Route::get('/', function () {
            if (Auth::check()) {
                return redirect()->route('client.home');
            } else {
                return redirect()->route('client.login');
            }
        })
            ->name('main');

        Route::view('login', 'clientViews.login')
            ->name('login');
        Route::post('login', 'AuthController@login')
            ->name('loginPost');

        Route::middleware(['auth', 'checkClient'])->group(function () {
            Route::view('firstLoginRegistration', 'clientViews.firstLoginRegistration')
                ->name('firstLoginRegistration');
            Route::view('homeProfileCreate', 'clientViews.homeProfileCreate')
                ->name('homeProfileCreate');
            Route::view('newProjectSetUp', 'clientViews.newProjectSetUp')
                ->name('newProjectSetUp');

            Route::get('home', 'HomeController@home')
                ->name('home');
            Route::view('profile', 'clientViews.profile')
                ->name('profile');
            // They have decided to remove profile editing, but I'm keeping this for when they eventually decide to change their mind
            // Route::view('profileEdit', 'clientViews.profileEdit')
            //     ->name('profileEdit');


            Route::middleware(['checkClientOwnsProject'])->group(function () {
                Route::get('project/home/{project}', 'ProjectController@home')
                    ->name('projectHome');
                Route::get('project/view/{project}', 'ProjectController@view')
                    ->name('projectView');
                Route::get('project/valueTargeting/{project}', 'ProjectController@valueTargeting')
                    ->name('projectValueTargeting');
                Route::get('project/orals/{project}', 'ProjectController@orals')
                    ->name('projectOrals');
                Route::get('project/conclusions/{project}', 'ProjectController@conclusions')
                    ->name('projectConclusions');

                Route::get('project/benchmark/{project}', 'ProjectController@benchmark')
                    ->name('projectBenchmark');
                Route::get('project/benchmark/fitgap/{project}', 'ProjectController@benchmarkFitgap')
                    ->name('projectBenchmarkFitgap');
                Route::get('project/benchmark/vendor/{project}', 'ProjectController@benchmarkVendor')
                    ->name('projectBenchmarkVendor');
                Route::get('project/benchmark/experience/{project}', 'ProjectController@benchmarkExperience')
                    ->name('projectBenchmarkExperience');
                Route::get('project/benchmark/innovation/{project}', 'ProjectController@benchmarkInnovation')
                    ->name('projectBenchmarkInnovation');
                Route::get('project/benchmark/implementation/{project}', 'ProjectController@benchmarkImplementation')
                    ->name('projectBenchmarkImplementation');

                Route::view('viewVendorProposal', 'clientViews.viewVendorProposal')
                    ->name('viewVendorProposal');
            });
        });
    });
