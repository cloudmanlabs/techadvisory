<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::
    prefix('accenture')
    ->name('accenture.')
    ->namespace('Accenture')
    ->group(function () {
        Route::get('/', function(){
            if(Auth::check() && Auth::user()->isAccenture()){
                return redirect()->route('accenture.home');
            } else {
                return redirect()->route('accenture.login');
            }
        })
            ->name('main');

        Route::view('login', 'accentureViews.login')
            ->name('login');
        Route::post('login', 'AuthController@login')
            ->name('loginPost');

        Route::middleware(['auth', 'checkAccenture'])->group(function () {
            Route::get('home', 'HomeController@home')
                ->name('home');
            Route::post('createProject', 'ProjectController@createPost')
                ->name('createProject');
            Route::get('newProjectSetUp/{project}', 'ProjectController@newProjectSetUp')
                ->name('newProjectSetUp');
            Route::post('/newProjectSetUp/changeProjectName', 'ProjectController@changeProjectName');
            Route::post('/newProjectSetUp/changeProjectClient', 'ProjectController@changeProjectClient');
            Route::post('/newProjectSetUp/changeProjectHasValueTargeting', 'ProjectController@changeProjectHasValueTargeting');
            Route::post('/newProjectSetUp/changeProjectIsBinding', 'ProjectController@changeProjectIsBinding');
            Route::post('/newProjectSetUp/changePractice', 'ProjectController@changePractice');
            Route::post('/newProjectSetUp/changeSubpractice', 'ProjectController@changeSubpractice');
            Route::post('/newProjectSetUp/setStep4Finished', 'ProjectController@setStep4Finished');


            Route::get('clientList', 'ClientVendorListController@clientList')
                ->name('clientList');
            Route::redirect('createNewClient', '/accenture/clientList') // TODO Here we should create the new client and stuff
                ->name('createNewClient');
            Route::get('clientProfileEdit/{client}', 'ClientVendorListController@clientProfileEdit')
                ->name('clientProfileEdit');
            Route::get('clientProfileView/{client}', 'ClientVendorListController@clientProfileView')
                ->name('clientProfileView');

            Route::redirect('createNewVendor', '/accenture/vendorHomeProfileCreate') // TODO Here we should create the new vendor and stuff
                ->name('createNewVendor');
            Route::get('vendorList', 'ClientVendorListController@vendorList')
                ->name('vendorList');
            Route::get('vendorProfileEdit/{vendor}', 'ClientVendorListController@vendorProfileEdit')
                ->name('vendorProfileEdit');
            Route::get('vendorProfileView/{vendor}', 'ClientVendorListController@vendorProfileView')
                ->name('vendorProfileView');

            Route::view('vendorValidateResponses', 'accentureViews.vendorValidateResponses')
                ->name('vendorValidateResponses');

            Route::get('project/home/{project}', 'ProjectController@home')
                ->name('projectHome');
            Route::get('project/view/{project}', 'ProjectController@view')
                ->name('projectView');
            Route::get('project/edit/{project}', 'ProjectController@edit')
                ->name('projectEdit');
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

            Route::view('viewVendorProposal', 'accentureViews.viewVendorProposal')
                ->name('viewVendorProposal');
            Route::view('viewVendorProposalEvaluation', 'accentureViews.viewVendorProposalEvaluation')
                ->name('viewVendorProposalEvaluation');

            Route::view('analysis/vendor', 'accentureViews.analysisVendor')
                ->name('analysisVendor');
            Route::view('analysis/client', 'accentureViews.analysisClient')
                ->name('analysisClient');
            Route::view('analysis/historical', 'accentureViews.analysisHistorical')
                ->name('analysisHistorical');
            Route::view('analysis/other', 'accentureViews.analysisOther')
                ->name('analysisOther');
        });
    });
