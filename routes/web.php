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

Route::middleware(['auth'])->group(function() {
    Route::get('/schedule', 'AgendaController@index')->name('schedule');
    Route::get('/schedule/detail/{id}', 'AgendaController@detail');
    Route::post('/schedule/post', 'AgendaController@post');
    Route::get('/availability', 'AvailabilityController@index')->name('availability');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::get('/toggle-availability/{date}/{available}', 'AvailabilityController@toggleAvailability')->name('toggle-availability');

    Route::get('/questions/template/{id}', 'QuestionsController@view_questions');
    Route::get('/questions/score/template/{id}', 'QuestionsController@score_questions');

    Route::get('/store', 'AgendaController@upload_selector')->name('get_store');
    Route::post('/store', 'AgendaController@store_file')->name('store');
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/admin/upload-questions', 'AdminController@uploadQuestions')->name('uploadQuestions');
    Route::post('admin/import-parse', 'AdminController@parseImport')->name('admin/import-parse');
    Route::post('admin/import-process', 'AdminController@processImport')->name('admin/import-process');

    Route::get('/admin/users', 'AdminController@users')->name('admin/users');
    Route::get('/admin/clients', 'Admin\ClientController@index')->name('admin/clients');
    Route::get('/admin/schedules', 'Admin\ScheduleController@index')->name('admin/schedules');
    Route::get('/admin/questions', 'Admin\QuestionController@index')->name('admin/questions');

    Route::get('/admin/question_templates', 'Admin\QuestionTemplateController@index')->name('admin/question_templates');
    Route::get('/admin/question_templates/{id}', 'Admin\QuestionTemplateController@template')->name('admin/question_templates/edit');
});

