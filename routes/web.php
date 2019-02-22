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
Route::get('/schedule/detail/{id}', 'AgendaController@detail');
Route::post('/schedule/post', 'AgendaController@post');
Route::get('/availability', 'AvailabilityController@index')->name('availability');
Route::get('/schedule/detail/{id}', 'AgendaController@detail');
Route::get('/settings', 'SettingsController@index')->name('settings');
Route::get('/toggle-availability/{date}/{available}', 'AvailabilityController@toggleAvailability')->name('toggle-availability');

Route::get('/questions/template/{id}', 'QuestionsController@view_questions');


Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/upload-questions', 'AdminController@uploadQuestions')->name('uploadQuestions');
Route::post('admin/import-parse', 'AdminController@parseImport')->name('admin/import-parse');
Route::post('admin/import-process', 'AdminController@processImport')->name('admin/import-process');


Route::get('/store', 'AgendaController@upload_selector')->name('get_store');
Route::post('/store', 'AgendaController@store_file')->name('store');