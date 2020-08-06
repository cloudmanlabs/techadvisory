<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Project;
use Carbon\Carbon;



Route::prefix('vendors')
    ->name('vendor.')
    ->namespace('Vendor')
    ->group(function () {
        Route::get('/', function () {
            if (Auth::check()) {
                if (auth()->user()->hasFinishedSetup) {
                    return redirect()->route('vendor.home');
                } else {
                    return redirect()->route('vendor.firstLoginRegistration');
                }
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
            Route::middleware(['checkUserHasNotFinishedSetup'])->group(function () {
                Route::view('firstLoginRegistration', 'vendorViews.firstLoginRegistration')
                    ->name('firstLoginRegistration');
                Route::get('profile/create', 'ProfileController@homeProfileCreate')
                    ->name('profile.create');
                Route::post('/profile/changeResponse', 'ProfileController@changeResponse')
                    ->name('profile.changeResponse');
            });

            Route::middleware(['checkUserHasFinishedSetup'])->group(function () {
                Route::get('home', 'HomeController@home')
                    ->name('home');
                Route::get('profile', 'ProfileController@profile')
                    ->name('profile');

                Route::get('previewProject/{project}', 'ProjectController@previewProject')
                    ->name('previewProject');
                Route::get('previewProjectApply/{project}', 'ProjectController@previewProjectApply')
                    ->name('previewProjectApply');

                Route::get('newApplication/{project}', 'ProjectController@newApplication')
                    ->name('newApplication');
                Route::get('newApplication/apply/{project}', 'ProjectController@newApplicationApply')
                    ->name('newApplication.apply');
                Route::get('newApplication/orals/{project}', 'ProjectController@projectOrals')
                    ->name('newApplication.orals');

                Route::get('submittedApplication/{project}', 'ProjectController@submittedApplication')
                    ->name('submittedApplication');


                Route::post('application/setRejected/{project}', 'ProjectController@setRejected')
                    ->name('application.setRejected');
                Route::post('application/setAccepted/{project}', 'ProjectController@setAccepted')
                    ->name('application.setAccepted');
                Route::post('application/setSubmitted/{project}', 'ProjectController@setSubmitted')
                    ->name('application.setSubmitted');


                Route::get('solutions', 'SolutionController@solutionHome')
                    ->name('solutions');
                Route::post('solution/create', 'SolutionController@createSolution')
                    ->name('createSolution');
                Route::get('solution/setup/{solution}', 'SolutionController@newSolutionSetUp')
                    ->name('newSolutionSetUp');
                Route::get('solution/edit/{solution}', 'SolutionController@solutionEdit')
                    ->name('solutionEdit');
                Route::post('solution/changeResponse', 'SolutionController@changeResponse')
                    ->name('profile.changeResponse');
                Route::post('solution/changeName', 'SolutionController@changeSolutionName')
                    ->name('profile.changeSolutionName');
                Route::post('solution/changePractice', 'SolutionController@changeSolutionPractice')
                    ->name('profile.changeSolutionPractice');


                //      ***   TESTING SPRINT 1 PUNTO 1 **********************************************************
                Route::get('example', function () {
                    return $result = "Hola";
                });


                // Test if DB retrieve data of Table project. (using Eloquent)
                // Note: min id = 7
                Route::get('firstProject', function () {
                    return App\Project::find(7)->name;
                });


                // Test if DB retrieve data with parameters of Table project and pretty print well
                // Note: min id = 7
                Route::get('project/{id}', function ($id) {
                    $project = Project::find($id);
                    //echo '<pre>' . var_export($project, true) . '</pre>';     // print


                    //echo $project;
                });

                // test advanced querys for table project.
                Route::get('project365',function (){

                    $current_date = date('Y-m-d H:i:s');

                    // Date range limit
                    $date_limit = Carbon::parse($current_date)->addMonths(-12)->format('Y-m-d');

                    // Query: Last year proyects filtered
                    $projects = App\Project::select('id','name','created_at')
                        ->where('industry','Automative')
                        ->whereDate('created_at', '<',$date_limit)
                        ->orderby('created_at')
                        ->first();

                    var_dump($projects);
                    die();


                });

                // test one to one relations.
                Route::get('/project/{id}/client', function ($id) {
                    return Project::find($id)->client_id;
                });
            });
        });
    });


