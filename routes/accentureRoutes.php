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
            Route::post('/newProjectSetUp/changeProjectHasOrals', 'ProjectController@changeProjectHasOrals');
            Route::post('/newProjectSetUp/changeProjectIsBinding', 'ProjectController@changeProjectIsBinding');
            Route::post('/newProjectSetUp/changePractice', 'ProjectController@changePractice');
            Route::post('/newProjectSetUp/changeSubpractice', 'ProjectController@changeSubpractice');
            Route::post('/newProjectSetUp/changeIndustry', 'ProjectController@changeIndustry');
            Route::post('/newProjectSetUp/changeRegions', 'ProjectController@changeRegions');
            Route::post('/newProjectSetUp/changeProjectType', 'ProjectController@changeProjectType');
            Route::post('/newProjectSetUp/changeDeadline', 'ProjectController@changeDeadline');
            Route::post('/newProjectSetUp/changeRFPOtherInfo', 'ProjectController@changeRFPOtherInfo');
            Route::post('/newProjectSetUp/setStep3Submitted', 'ProjectController@setStep3Submitted');
            Route::post('/newProjectSetUp/setStep4Submitted', 'ProjectController@setStep4Submitted');
            Route::post('/newProjectSetUp/publishProject', 'ProjectController@publishProject');
            Route::post('/newProjectSetUp/publishProjectAnalytics', 'ProjectController@publishProjectAnalytics');
            Route::post('/newProjectSetUp/updateVendors', 'ProjectController@updateVendors');
            Route::post('/newProjectSetUp/updateScoringValues', 'ProjectController@updateScoringValues');

            Route::post('/orals/changeLocation', 'ProjectController@changeOralsLocation');
            Route::post('/orals/changeFromDate', 'ProjectController@changeOralsFromDate');
            Route::post('/orals/changeToDate', 'ProjectController@changeOralsToDate');

            Route::post('/orals/changeInvitedToOrals', 'VendorApplicationController@changeInvitedToOrals');
            Route::post('/orals/changeOralsCompleted', 'VendorApplicationController@changeOralsCompleted');



            Route::post('createClient', 'ClientVendorListController@createClientPost')
                ->name('createClient');
            Route::get('clientList', 'ClientVendorListController@clientList')
                ->name('clientList');
            Route::get('clientProfileEdit/{client}', 'ClientVendorListController@clientProfileEdit')
                ->name('clientProfileEdit');
            Route::post('clientProfileEdit/changeResponse', 'ClientVendorListController@changeClientProfileResponse');
            Route::post('clientProfileEdit/changeName', 'ClientVendorListController@changeClientName');
            Route::post('clientProfileEdit/changeEmail', 'ClientVendorListController@changeClientEmail');
            Route::post('clientProfileEdit/createFirstCredential', 'ClientVendorListController@createFirstClientCredential');
            Route::get('clientProfileView/{client}', 'ClientVendorListController@clientProfileView')
                ->name('clientProfileView');

            Route::post('createVendor', 'ClientVendorListController@createVendorPost')
                ->name('createVendor');
            Route::get('vendorList', 'ClientVendorListController@vendorList')
                ->name('vendorList');
            Route::get('vendorProfileEdit/{vendor}', 'ClientVendorListController@vendorProfileEdit')
                ->name('vendorProfileEdit');
            Route::post('vendorProfileEdit/changeResponse', 'ClientVendorListController@changeVendorProfileResponse');
            Route::post('vendorProfileEdit/changeName', 'ClientVendorListController@changeVendorName');
            Route::post('vendorProfileEdit/changeEmail', 'ClientVendorListController@changeVendorEmail');
            Route::post('vendorProfileEdit/createFirstCredential', 'ClientVendorListController@createFirstVendorCredential');
            Route::get('vendorProfileView/{vendor}', 'ClientVendorListController@vendorProfileView')
                ->name('vendorProfileView');
            Route::get('vendorSolution/{solution}', 'ClientVendorListController@vendorSolution')
                ->name('vendorSolution');
            Route::get('vendorSolution/edit/{solution}', 'ClientVendorListController@vendorSolutionEdit')
                ->name('vendorSolutionEdit');
            Route::post('vendorSolution/changeResponse', 'ClientVendorListController@changeSolutionResponse');
            Route::post('vendorSolution/changeName', 'ClientVendorListController@changeSolutionName');

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

            Route::post('project/disqualifyVendor/{project}/{vendor}', 'ProjectController@disqualifyVendor')
                ->name('project.disqualifyVendor');
            Route::post('project/releaseResponse/{project}/{vendor}', 'ProjectController@releaseResponse')
                ->name('project.releaseResponse');


            Route::get('/project/vendorProposal/view/{project}/{vendor}', 'ProjectController@vendorProposalView')
                ->name('viewVendorProposal');
            Route::get('/project/vendorProposal/edit/{project}/{vendor}', 'ProjectController@vendorProposalEdit')
                ->name('editVendorProposal');
            Route::get('/project/vendorProposal/evaluate/{project}/{vendor}', 'ProjectController@vendorProposalEvaluation')
                ->name('viewVendorProposalEvaluation');
            Route::post('project/submitEvaluation/{project}/{vendor}', 'ProjectController@submitEvaluation')
                ->name('project.submitEvaluation');
            Route::get('/project/vendorProposal/download/{project}/{vendor}', 'ProjectController@downloadVendorProposal')
                ->name('downloadVendorProposal');

            Route::get('analysis/project/vendor', 'AnalysisController@projectVendor')
                ->name('analysis.project.vendor');
            Route::get('analysis/project/client', 'AnalysisController@projectClient')
                ->name('analysis.project.client');
            Route::get('analysis/project/historical', 'AnalysisController@projectHistorical')
                ->name('analysis.project.historical');
            Route::get('analysis/project/custom', 'AnalysisController@projectCustom')
                ->name('analysis.project.custom');

            Route::get('analysis/vendor/graphs', 'AnalysisController@vendorGraphs')
                ->name('analysis.vendor.graphs');
            Route::get('analysis/vendor/custom', 'AnalysisController@vendorCustom')
                ->name('analysis.vendor.custom');
        });
    });
