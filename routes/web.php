<?php

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
Auth::routes();
//Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/schedule', 'AgendaController@index')->name('schedule');
Route::get('/availability', 'AvailabilityController@index')->name('availability');
Route::get('/settings', 'SettingsController@index')->name('settings');
Route::get('/toggle-availability/{date}/{available}', 'AvailabilityController@toggleAvailability')->name('toggle-availability');