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
    return view('welcome');
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
