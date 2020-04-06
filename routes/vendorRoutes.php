<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;



Route::prefix('vendors')
    ->name('vendor.')
    ->namespace('Vendor')
    ->group(function () {
        Route::get('/', function () {
            if (Auth::check()) {
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
