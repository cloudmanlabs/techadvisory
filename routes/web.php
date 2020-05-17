<?php

use App\Project;
use App\User;
use App\VendorApplication;
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


Route::middleware(['auth'])->group(function () {
    Route::post('/generalInfoQuestion/changeResponse', 'GeneralInfoQuestionController@changeResponse');
    Route::post('/sizingQuestion/changeResponse', 'SizingQuestionController@changeResponse');
    Route::post('/sizingQuestion/setShouldShow', 'SizingQuestionController@setShouldShow');
    Route::post('/selectionCriteriaQuestion/changeResponse', 'SelectionCriteriaQuestionController@changeResponse');
    Route::post('/selectionCriteriaQuestion/changeScore', 'SelectionCriteriaQuestionController@changeScore');


    Route::post('/user/changeLogo', 'UserController@changeLogo');
    Route::post('/accenture/changeSomeoneElsesLogo', 'UserController@changeSomeoneElsesLogo')
        ->middleware('checkAccenture');


    Route::post('folder/uploadFilesToFolder', 'FolderController@uploadFiles');
    Route::post('folder/uploadSingleFileToFolder', 'FolderController@uploadSingleFile');
    Route::post('folder/removeFile', 'FolderController@removeFile');




    Route::post('import5Columns/{project}', 'FitgapController@import5Columns')
        ->name('import5Columns');

    Route::get('fitgapClientJson/{project}', 'FitgapController@clientJson')
        ->name('fitgapClientJson');
    Route::get('fitgapVendorJson/{vendor}/{project}', 'FitgapController@vendorJson')
        ->name('fitgapVendorJson');
    Route::get('fitgapEvaluationJson/{vendor}/{project}', 'FitgapController@evaluationJson')
        ->name('fitgapEvaluationJson');

    Route::post('fitgapClientJson/{project}', 'FitgapController@clientJsonUpload')
        ->name('fitgapClientJsonUpload');
    Route::post('fitgapVendorJson/{vendor}/{project}', 'FitgapController@vendorJsonUpload')
        ->name('fitgapVendorJsonUpload');
    Route::post('fitgapEvaluationJson/{vendor}/{project}', 'FitgapController@evaluationJsonUpload')
        ->name('fitgapEvaluationJsonUpload');

    Route::get('fitgapClientIframe/{project}', 'FitgapController@clientIframe')
        ->name('fitgapClientIframe');
    Route::get('fitgapVendorIframe/{vendor}/{project}', 'FitgapController@vendorIframe')
        ->name('fitgapVendorIframe');
    Route::get('fitgapEvaluationIframe/{vendor}/{project}', 'FitgapController@evaluationIframe')
        ->name('fitgapEvaluationIframe');
});


Route::get('testing', function(){

});
