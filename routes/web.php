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
    Route::post('/settings/save', 'SettingsController@save')->name('saveSettings');
    Route::get('/toggle-availability/{date}/{available}', 'AvailabilityController@toggleAvailability')->name('toggle-availability');

    Route::get('/questions/call/{id}', 'QuestionsController@viewQuestions')->name('viewQuestions');

    Route::get('/store', 'AgendaController@upload_selector')->name('get_store');
    Route::post('/store', 'AgendaController@store_file')->name('store');

    Route::post('/call/complete', 'AgendaController@completeCall')->name('completeCall');
});

Route::middleware(['auth', 'coach'])->group(function() {
    Route::get('/questions/score/call/{id}', 'QuestionsController@scoreQuestionsView')->name('scoreCallView');
    Route::post('/call/score', 'QuestionsController@scoreQuestions')->name('scoreCall');
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/admin/upload-questions', 'AdminController@uploadQuestions')->name('uploadQuestions');
    Route::post('admin/import-parse', 'AdminController@parseImport')->name('admin/import-parse');
    Route::post('admin/import-process', 'AdminController@processImport')->name('admin/import-process');

    Route::get('/admin/users', 'AdminController@users')->name('admin/users');
    Route::get('/admin/users/{id}', 'AdminController@editUser')->name('admin/users/edit');
    Route::post('/admin/users/update/{id}', 'AdminController@updateUser')->name('admin/users/update');

    Route::get('/admin/clients', 'Admin\ClientController@index')->name('admin/clients');
    Route::get('/admin/clients/{id}', 'Admin\ClientController@show')->name('admin/clients/show');
    Route::post('/admin/clients/edit/{id}', 'Admin\ClientController@edit')->name('admin/clients/edit');

    Route::get('/admin/companies', 'Admin\CompanyController@index')->name('admin/companies');
    Route::get('/admin/companies/{id}', 'Admin\CompanyController@edit')->name('admin/companies/edit');
    Route::post('/admin/companies/update/{id}', 'Admin\CompanyController@update')->name('admin/companies/update');

    Route::get('/admin/regions', 'Admin\RegionController@index')->name('admin/regions');
    Route::get('/admin/regions/{id}', 'Admin\RegionController@edit')->name('admin/regions/edit');
    Route::post('/admin/regions/update/{id}', 'Admin\RegionController@update')->name('admin/regions/update');

    Route::get('/admin/categories', 'Admin\CategoryController@index')->name('admin/categories');
    Route::get('/admin/categories/{id}', 'Admin\CategoryController@edit')->name('admin/categories/edit');
    Route::post('/admin/categories/update/{id}', 'Admin\CategoryController@update')->name('admin/categories/update');

    Route::get('/admin/schedules', 'Admin\ScheduleController@index')->name('admin/schedules');
    Route::get('/admin/schedules/{id}', 'Admin\ScheduleController@edit')->name('admin/schedules/edit');
    Route::post('/admin/schedule/modify', 'Admin\ScheduleController@modify')->name('modifySchedule');

    Route::get('/admin/calls/', 'Admin\CallController@show')->name('admin/calls');
    Route::get('/admin/calls/{id}', 'Admin\CallController@show')->name('admin/calls/show');
    Route::get('/admin/settings', 'Admin\CallController@settings')->name('admin/settings');

    Route::get('/admin/questions', 'Admin\QuestionController@index')->name('admin/questions');
    Route::get('/admin/questions/{id}', 'Admin\QuestionController@show')->name('admin/questions/show');
    Route::post('/admin/questions/edit/{id}', 'Admin\QuestionController@edit')->name('admin/questions/edit');

    Route::get('/admin/question_templates', 'Admin\QuestionTemplateController@index')->name('admin/question_templates');
    Route::get('/admin/question_templates/{id}', 'Admin\QuestionTemplateController@template')->name('admin/question_templates/edit');

    Route::get('/admin/language/{id}', 'Admin\CallController@showLanguage')->name('admin/language');
    Route::post('/admin/language/edit/{id}', 'Admin\CallController@editLanguage')->name('admin/language/edit');
    Route::get('/admin/call/type/{id}', 'Admin\CallController@showCallType')->name('admin/call/type');
    Route::post('/admin/call/type/edit/{id}', 'Admin\CallController@editCallType')->name('admin/call/type/edit');

    Route::get('/admin/reports', 'Admin\ReportController@index')->name('admin/reports');
    Route::get('/admin/reports/incomplete/{date?}', 'Admin\ReportController@incomplete')->name('admin/reports/incomplete');
    Route::get('/admin/reports/unscored/{date?}', 'Admin\ReportController@unscored')->name('admin/reports/unscored');

    Route::post('/admin/schedule/agents', 'Admin\ScheduleController@modifyAgents')->name('modifyAgents');
});

