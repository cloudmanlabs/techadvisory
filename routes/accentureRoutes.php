<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::
prefix('accenture')
    ->name('accenture.')
    ->namespace('Accenture')
    ->group(function () {
        Route::get('/', function () {
            if (Auth::check() && Auth::user()->isAccenture()) {
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
            Route::get('newProjectSetUp/{project}/useCasesSetUp', 'ProjectController@useCasesSetUp')
                ->name('useCasesSetUp');

            // This started as just a couple fields,  but has been growing over time. I'd refactor it to be a single route or something, but it's a bit late now
            Route::post('/newProjectSetUp/upsertUseCaseAccentureUsers', 'ProjectController@upsertUseCaseAccentureUsers');
            Route::post('/newProjectSetUp/upsertUseCaseClientUsers', 'ProjectController@upsertUseCaseClientUsers');
            Route::post('/newProjectSetUp/upsertUseCaseName', 'ProjectController@upsertUseCaseName');
            Route::post('/newProjectSetUp/upsertUseCaseDescription', 'ProjectController@upsertUseCaseDescription');
            Route::post('/newProjectSetUp/upsertEvaluationSolutionFit', 'ProjectController@upsertEvaluationSolutionFit');
            Route::post('/newProjectSetUp/upsertEvaluationUsability', 'ProjectController@upsertEvaluationUsability');
            Route::post('/newProjectSetUp/upsertEvaluationPerformance', 'ProjectController@upsertEvaluationPerformance');
            Route::post('/newProjectSetUp/upsertEvaluationLookFeel', 'ProjectController@upsertEvaluationLookFeel');
            Route::post('/newProjectSetUp/upsertEvaluationOthers', 'ProjectController@upsertEvaluationOthers');
            Route::post('/newProjectSetUp/upsertEvaluationComments', 'ProjectController@upsertEvaluationComments');
            Route::post('/newProjectSetUp/submitUseCaseVendorEvaluation', 'ProjectController@submitUseCaseVendorEvaluation');
            Route::post('/newProjectSetUp/rollbackSubmitUseCaseVendorEvaluation', 'ProjectController@rollbackSubmitUseCaseVendorEvaluation');
//            Route::post('/newProjectSetUp/cacheUseCaseVendorEvaluation', 'ProjectController@cacheUseCaseVendorEvaluation');
            Route::post('/newProjectSetUp/cacheProjectVendorEvaluation', 'ProjectController@cacheProjectVendorEvaluation');
            Route::post('/newProjectSetUp/updateInvitedVendors', 'ProjectController@updateInvitedVendors');
            Route::post('/newProjectSetUp/saveProjectScoringCriteria', 'ProjectController@saveProjectScoringCriteria');
            Route::post('/newProjectSetUp/saveUseCaseScoringCriteria', 'ProjectController@saveUseCaseScoringCriteria');
            Route::post('/newProjectSetUp/saveVendorEvaluation', 'ProjectController@saveVendorEvaluation');
            Route::post('/newProjectSetUp/saveCaseUse', 'ProjectController@createCaseUse');
            Route::post('/newProjectSetUp/changeProjectName', 'ProjectController@changeProjectName');
            Route::post('/newProjectSetUp/changeProjectOwner', 'ProjectController@changeProjectOwner');
            Route::post('/newProjectSetUp/changeProjectClient', 'ProjectController@changeProjectClient');
            Route::post('/newProjectSetUp/changeProjectHasValueTargeting', 'ProjectController@changeProjectHasValueTargeting');
            Route::post('/newProjectSetUp/changeProjectHasOrals', 'ProjectController@changeProjectHasOrals');
            Route::post('/newProjectSetUp/changeProjectUseCases', 'ProjectController@changeProjectUseCases');
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
            Route::post('/ProjectController/setStep1Rollback', 'ProjectController@setStep1Rollback');
            Route::post('/ProjectController/setStep2Rollback', 'ProjectController@setStep2Rollback');
            Route::post('/ProjectController/setStep3Rollback', 'ProjectController@setStep3Rollback');
            Route::post('/ProjectController/setStep4Rollback', 'ProjectController@setStep4Rollback');
            Route::post('/newProjectSetUp/setStep4Submitted', 'ProjectController@setStep4Submitted');
            Route::post('/newProjectSetUp/publishProject', 'ProjectController@publishProject');
            Route::post('/newProjectSetUp/publishUseCases', 'ProjectController@publishUseCases');
            Route::post('/newProjectSetUp/togglePublishProjectAnalytics', 'ProjectController@togglePublishProjectAnalytics');
            Route::post('/newProjectSetUp/updateVendors', 'ProjectController@updateVendors');
            Route::post('/newProjectSetUp/updateScoringValues', 'ProjectController@updateScoringValues');
            Route::post('/newProjectSetUp/changeWeights', 'ProjectController@changeWeights');

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
            Route::get('vendorValidateResponses/{vendor}', 'ClientVendorListController@vendorValidateResponses')
                ->name('vendorValidateResponses');
            Route::post('vendorValidateResponses/setValidated/{vendor}', 'ClientVendorListController@setValidated');
            Route::post('vendorValidateResponses/submitVendor/{vendor}', 'ClientVendorListController@submitVendor')
                ->name('submitVendor');
            Route::get('vendorSolution/{solution}', 'ClientVendorListController@vendorSolution')
                ->name('vendorSolution');
            Route::get('vendorSolution/edit/{solution}', 'ClientVendorListController@vendorSolutionEdit')
                ->name('vendorSolutionEdit');
            Route::post('vendorSolution/changeResponse', 'ClientVendorListController@changeSolutionResponse');
            Route::post('vendorSolution/changeName', 'ClientVendorListController@changeSolutionName');
            Route::post('vendorSolution/changePractice', 'ClientVendorListController@changeSolutionPractice');

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
            Route::get('project/useCases/{project}', 'ProjectController@useCasesSetUp')
                ->name('projectUseCasesSetUp');
            Route::get('project/useCasesRollback/{project}', 'ProjectController@useCasesSetUpRollback')
                ->name('evaluationRollback');

            Route::get('project/benchmark/{project}', 'ProjectController@benchmark')
                ->name('projectBenchmark');
            Route::get('project/RFPAndUseCasesBenchmark/{project}', 'ProjectController@RFPAndUseCasesBenchmark')
                ->name('projectRFPAndUseCasesBenchmark');

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
            Route::get('project/benchmark/vendorComparison/{project}', 'ProjectController@benchmarkVendorComparison')
                ->name('projectBenchmarkVendorComparison');
            Route::get('project/benchmark/usecases/{project}', 'ProjectController@benchmarkUseCases')
                ->name('projectBenchmarkUseCases');

            Route::post('project/disqualifyVendor/{project}/{vendor}', 'ProjectController@disqualifyVendor')
                ->name('project.disqualifyVendor');
            Route::post('project/releaseResponse/{project}/{vendor}', 'ProjectController@releaseResponse')
                ->name('project.releaseResponse');
            Route::post('/project/resendInvitation', 'ProjectController@resendInvitation');

            Route::post('project/markCompleted/{project}', 'ProjectController@markCompleted')
                ->name('project.markCompleted');
            Route::post('project/moveToOpen/{project}', 'ProjectController@moveToOpen')
                ->name('project.moveToOpen');

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

            Route::get('/exportCredentials/{user}', 'ClientVendorListController@exportCredentials');
            Route::get('/exportAnalytics/{project}', 'ProjectController@exportAnalytics')
                ->name('exportAnalytics');

            Route::get('/project/vendorApplyRollback/{project}/{vendor}', 'ProjectController@vendorApplyRollback')
                ->name('project.vendorApplyRollback');

            Route::get('/analysis/vendor/custom/getScopes/{practice}', 'AnalysisController@getScopesfromPractice');
            Route::get('/analysis/vendor/custom/getSubpractices/{practice}', 'AnalysisController@getSubpracticesfromPractice');
            Route::get('/analysis/vendor/custom/getResponses', 'AnalysisController@getResponsesFromScope');

            Route::get('/benchmark/overview/', 'BenchmarkController@overviewGeneral')
                ->name('benchmark');
            Route::get('/benchmark/overview/historical', 'BenchmarkController@overviewHistorical')
                ->name('benchmark.overview.historical');
            Route::get('/benchmark/overview/vendor', 'BenchmarkController@overviewVendor')
                ->name('benchmark.overview.vendor');

            Route::get('/benchmark/projectResults', 'BenchmarkController@projectResultsOverall')
                ->name('benchmark.projectResults');
            Route::get('/benchmark/projectResults/useCasesOverall', 'BenchmarkController@projectUseCasesResultsOverall')
                ->name('benchmark.projectUseCasesResults');
            Route::get('/benchmark/projectResults/fitgap', 'BenchmarkController@projectResultsFitgap')
                ->name('benchmark.projectResults.fitgap');
            Route::get('/benchmark/projectResults/vendor', 'BenchmarkController@projectResultsVendor')
                ->name('benchmark.projectResults.vendor');
            Route::get('/benchmark/projectResults/experience', 'BenchmarkController@projectResultsExperience')
                ->name('benchmark.projectResults.experience');
            Route::get('/benchmark/projectResults/innovation', 'BenchmarkController@projectResultsInnovation')
                ->name('benchmark.projectResults.innovation');
            Route::get('/benchmark/projectResults/implementation', 'BenchmarkController@projectResultsImplementation')
                ->name('benchmark.projectResults.implementation');
            Route::get('/benchmark/projectResults/useCases', 'BenchmarkController@projectResultsUseCases')
                ->name('benchmark.projectResults.useCases');

            Route::get('/benchmark/customSearches/', 'BenchmarkController@customSearches')
                ->name('benchmark.customSearches');

            Route::get('/benchmark/customSearches/vendor', 'BenchmarkController@customSearchesVendor')
                ->name('benchmark.customSearches.vendor');

            Route::get('/benchmark/projectResults/getSubpractices/{practice}', 'BenchmarkController@getSubpracticesfromPractice');
            Route::get('/benchmark/customSearches/getSubpractices/{practice}', 'BenchmarkController@getSubpracticesfromPracticeName');

        });
    });
