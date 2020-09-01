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
                if(auth()->user()->hasFinishedSetup){
                    return redirect()->route('client.home');
                } else {
                    return redirect()->route('client.firstLoginRegistration');
                }
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
            Route::middleware(['checkUserHasNotFinishedSetup'])->group(function () {
                Route::view('firstLoginRegistration', 'clientViews.firstLoginRegistration')
                    ->name('firstLoginRegistration');
                Route::get('profile/create', 'ProfileController@homeProfileCreate')
                    ->name('profile.create');
                Route::post('/profile/changeResponse', 'ProfileController@changeResponse')
                    ->name('profile.changeResponse');
                Route::post('profile/submit', 'ProfileController@submitProfile')
                    ->name('profile.submit');
            });

            Route::middleware(['checkUserHasFinishedSetup'])->group(function(){
                Route::get('home', 'HomeController@home')
                    ->name('home');

                Route::get('profile', 'ProfileController@profile')
                    ->name('profile');

                Route::middleware(['checkClientOwnsProject'])->group(function () {
                    Route::get('newProjectSetUp/{project}', 'ProjectController@newProjectSetUp')
                        ->name('newProjectSetUp');
                    Route::post('/newProjectSetUp/changeProjectName', 'ProjectController@changeProjectName');
                    Route::post('/newProjectSetUp/changeProjectHasValueTargeting', 'ProjectController@changeProjectHasValueTargeting');
                    Route::post('/newProjectSetUp/changeProjectHasOrals', 'ProjectController@changeProjectHasOrals');
                    Route::post('/newProjectSetUp/changeProjectIsBinding', 'ProjectController@changeProjectIsBinding');
                    Route::post('/newProjectSetUp/changePractice', 'ProjectController@changePractice');
                    Route::post('/newProjectSetUp/changeSubpractice', 'ProjectController@changeSubpractice');
                    Route::post('/newProjectSetUp/changeIndustry', 'ProjectController@changeIndustry');
                    Route::post('/newProjectSetUp/changeRegions', 'ProjectController@changeRegions');
                    Route::post('/newProjectSetUp/changeProjectType', 'ProjectController@changeProjectType');
                    Route::post('/newProjectSetUp/changeCurrency', 'ProjectController@changeCurrency');
                    Route::post('/newProjectSetUp/changeDeadline', 'ProjectController@changeDeadline');
                    Route::post('/newProjectSetUp/changeRFPOtherInfo', 'ProjectController@changeRFPOtherInfo');
                    Route::post('/newProjectSetUp/setStep3Submitted', 'ProjectController@setStep3Submitted');
                    Route::post('/newProjectSetUp/setStep4Submitted', 'ProjectController@setStep4Submitted');
                    Route::post('/newProjectSetUp/updateScoringValues', 'ProjectController@updateScoringValues');
                    Route::post('/newProjectSetUp/changeWeights', 'ProjectController@changeWeights');

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

                    Route::get('/project/vendorProposal/view/{project}/{vendor}', 'ProjectController@vendorProposalView')
                        ->name('viewVendorProposal');
                    Route::get('/project/vendorProposal/download/{project}/{vendor}', 'ProjectController@downloadVendorProposal')
                        ->name('downloadVendorProposal');

                    Route::get('/exportAnalytics/{project}', 'ProjectController@exportAnalytics')
                        ->name('exportAnalytics');
                });
            });
        });
    });
