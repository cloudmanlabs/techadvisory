<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')
    ->name('welcome');

Route::post('logout', function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    return redirect()->route('welcome');
})->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

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
            Route::view('clientList', 'accentureViews.clientList')
                ->name('clientList');
            Route::view('vendorList', 'accentureViews.vendorList')
                ->name('vendorList');
            Route::view('vendorHomeProfileCreate', 'accentureViews.vendorHomeProfileCreate')
                ->name('vendorHomeProfileCreate');
            Route::redirect('createNewVendor', '/accenture/vendorHomeProfileCreate') // TODO Here we should create the new vendor and stuff
                ->name('createNewVendor');
            Route::view('vendorValidateResponses', 'accentureViews.vendorValidateResponses')
                ->name('vendorValidateResponses');
            Route::view('clientHomeProfileCreate', 'accentureViews.clientHomeProfileCreate')
                ->name('clientHomeProfileCreate');
            Route::redirect('createNewClient', '/accenture/clientHomeProfileCreate') // TODO Here we should create the new client and stuff
                ->name('createNewClient');

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





            Route::post('/changeProjectName', 'ProjectController@changeProjectName');
            Route::post('/assignClient', 'ProjectController@assignClient');
        });
    });


Route::prefix('client')
    ->name('client.')
    ->namespace('Client')
    ->group(function () {
        Route::get('/', function(){
            if(Auth::check()){
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


            Route::middleware(['checkClientOwnsProject'])->group(function(){
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


Route::prefix('vendors')
    ->name('vendor.')
    ->namespace('Vendor')
    ->group(function () {
        Route::get('/', function(){
            Log::debug('message');
            if(Auth::check()){
                return redirect()->route('vendor.home');
            } else {
                return redirect()->route('vendor.login');
            }
        })
            ->name('main');

        Route::view('login', 'vendorViews.login')
            ->name('login');
        Route::post('login', 'AuthController@login')
            ->name('loginPost');

        Route::middleware(['auth', 'checkVendor'])->group(function () {
            Route::view('firstLoginRegistration', 'vendorViews.firstLoginRegistration')
                ->name('firstLoginRegistration');
            Route::view('homeProfileCreate', 'vendorViews.homeProfileCreate')
                ->name('homeProfileCreate');
            Route::view('newSolutionSetUp', 'vendorViews.newSolutionSetUp')
                ->name('newSolutionSetUp');

            Route::redirect('createNewApplication', '/vendor/newApplication') // TODO Here we should accept the  stuff and go to the newApplication to fill the data
                ->name('createNewApplication');
            Route::view('previewProject', 'vendorViews.previewProject')
                ->name('previewProject');
            Route::view('newApplication', 'vendorViews.newApplication')
                ->name('newApplication');
            Route::view('newApplicationApply', 'vendorViews.newApplicationApply')
                ->name('newApplicationApply');
            Route::view('projectOrals', 'vendorViews.projectOrals')
                ->name('projectOrals');


            Route::view('home', 'vendorViews.home')
                ->name('home');
            Route::view('profile', 'vendorViews.profile')
                ->name('profile');
            Route::view('solutionsHome', 'vendorViews.solutionsHome')
                ->name('solutionsHome');
            Route::view('solutionEdit', 'vendorViews.solutionEdit')
                ->name('solutionEdit');
        });
    });
