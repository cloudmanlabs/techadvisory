<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/accenture');
});



Route::
    prefix('accenture')
    ->name('accenture.')
    ->namespace('Accenture')
    ->group(function () {
        Route::get('/', function(){
            if(Auth::check()){
                return redirect()->route('accenture.home');
            } else {
                return redirect()->route('accenture.login');
            }
        });

        Route::view('home', 'accentureViews.home')
            ->name('home');
        Route::view('login', 'accentureViews.login')
            ->name('login');
        Route::view('newProjectSetUp', 'accentureViews.newProjectSetUp')
            ->name('newProjectSetUp');
        Route::view('clientList', 'accentureViews.clientList')
            ->name('clientList');
        Route::view('vendorList', 'accentureViews.vendorList')
            ->name('vendorList');

        Route::view('project/home', 'accentureViews.projectHome')
            ->name('projectHome');
        Route::view('project/editView', 'accentureViews.projectEditView')
            ->name('projectEditView');
        Route::view('project/valueTargeting', 'accentureViews.projectValueTargeting')
            ->name('projectValueTargeting');
        Route::view('project/orals', 'accentureViews.projectOrals')
            ->name('projectOrals');
        Route::view('project/conclusions', 'accentureViews.projectConclusions')
            ->name('projectConclusions');

        Route::view('project/benchmark', 'accentureViews.projectBenchmark')
            ->name('projectBenchmark');
        Route::view('project/benchmark/fitgap', 'accentureViews.projectBenchmarkFitgap')
            ->name('projectBenchmarkFitgap');
        Route::view('project/benchmark/vendor', 'accentureViews.projectBenchmarkVendor')
            ->name('projectBenchmarkVendor');
        Route::view('project/benchmark/experience', 'accentureViews.projectBenchmarkExperience')
            ->name('projectBenchmarkExperience');
        Route::view('project/benchmark/innovation', 'accentureViews.projectBenchmarkInnovation')
            ->name('projectBenchmarkInnovation');
        Route::view('project/benchmark/implementation', 'accentureViews.projectBenchmarkImplementation')
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
        });

        Route::view('home', 'clientViews.home')
            ->name('home');


        Route::view('login', 'clientViews.login')
            ->name('login');
    });



Route::prefix('vendor')
    ->name('vendor.')
    ->namespace('Vendor')
    ->group(function () {
        Route::get('/', function(){
            if(Auth::check()){
                return redirect()->route('vendor.home');
            } else {
                return redirect()->route('vendor.login');
            }
        });

        Route::view('home', 'vendorViews.home')
            ->name('home');


        Route::view('login', 'vendorViews.login')
            ->name('login');
    });
