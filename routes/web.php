<?php

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

// use default blade with server side rendering when possible
// SSR with vue or react can be an excellent alternative

// eventual middlewares and other stuff can be added here
Route::prefix('tracking')->group(function () {

    Route::get('/', 'App\Http\Controllers\TrackingController@index')->name('tracking.index');

    Route::get('/search', 'App\Http\Controllers\TrackingController@show')
        ->name('tracking.show');
});
