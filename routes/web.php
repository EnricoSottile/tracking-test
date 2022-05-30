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
Route::get('/tracking', function () {
    return view('tracking.index');
})->name('tracking.index');


Route::get('/tracking/{tracking?}', function () {
    return view('tracking.show');
})->name('tracking.show');
