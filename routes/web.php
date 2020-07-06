<?php

use App\Project;
use App\SecurityLog;
use App\SelectionCriteriaQuestionResponse;
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

Route::get('/test', function(){
    return nova_get_setting('test');
});

Route::view('/', 'welcome')
    ->name('welcome');
Route::view('/terms', 'terms')
    ->name('terms');
Route::view('/privacy', 'privacy')
    ->name('privacy');

Route::post('logout', function(Request $request){
    SecurityLog::createLog('User logged out');

    Auth::logout();
    $request->session()->invalidate();
    return redirect()->route('welcome');
})->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('changePassword/{token}', 'CredentialController@changePassword')
    ->name('credentials.changePassword');
Route::post('changePassword/{token}', 'CredentialController@changePasswordPost')
    ->name('credentials.changePasswordPost');

Route::get('enterEmail', 'CredentialController@enterEmail')
    ->name('credentials.enterEmail');
Route::post('enterEmail', 'CredentialController@enterEmailPost')
    ->name('credentials.enterEmailPost');


Route::middleware(['auth'])->group(function () {
    Route::post('/generalInfoQuestion/changeResponse', 'GeneralInfoQuestionController@changeResponse');
    Route::post('/sizingQuestion/changeResponse', 'SizingQuestionController@changeResponse');
    Route::post('/sizingQuestion/setShouldShow', 'SizingQuestionController@setShouldShow');
    Route::post('/selectionCriteriaQuestion/changeResponse', 'SelectionCriteriaQuestionController@changeResponse');
    Route::post('/selectionCriteriaQuestion/uploadFile', 'SelectionCriteriaQuestionController@uploadFile');
    Route::post('/selectionCriteriaQuestion/changeScore', 'SelectionCriteriaQuestionController@changeScore');

    Route::post('/vendorApplication/updateSolutionsUsed', 'Accenture\VendorApplicationController@updateSolutionsUsed');
    Route::post('/vendorApplication/updateDeliverables', 'Accenture\VendorApplicationController@updateDeliverables');
    Route::post('/vendorApplication/updateRaci', 'Accenture\VendorApplicationController@updateRaci');
    Route::post('/vendorApplication/updateStaffingCost', 'Accenture\VendorApplicationController@updateStaffingCost');
    Route::post('/vendorApplication/updateTravelCost', 'Accenture\VendorApplicationController@updateTravelCost');
    Route::post('/vendorApplication/updateAdditionalCost', 'Accenture\VendorApplicationController@updateAdditionalCost');
    Route::post('/vendorApplication/updateNonBindingImplementation', 'Accenture\VendorApplicationController@updateNonBindingImplementation');
    Route::post('/vendorApplication/updateEstimate5Years', 'Accenture\VendorApplicationController@updateEstimate5Years');
    Route::post('/vendorApplication/updateImplementationScores', 'Accenture\VendorApplicationController@updateImplementationScores');
    Route::post('/vendorApplication/updateRunFile', 'Accenture\VendorApplicationController@updateRunFile');

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
