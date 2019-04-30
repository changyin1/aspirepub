<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api'])->group(function(){
    Route::post('cities', 'Api\UtilitiesController@getCities');
    Route::post('availability', 'Api\AvailabilityController@submit');
    Route::get('availability', 'Api\AvailabilityController@get');

    Route::post('/admin/clients/create', 'Admin\ClientController@Create')->name('createClient');

    Route::post('/admin/companies/create', 'Admin\CompanyController@Create')->name('createCompany');

    Route::post('/admin/regions/create', 'Admin\RegionController@Create')->name('createRegion');

    Route::post('/admin/categories/create', 'Admin\CategoryController@Create')->name('createCategory');

    Route::post('/admin/questions/create', 'Admin\QuestionController@Create')->name('createQuestion');

    Route::post('/admin/question_templates/create', 'Admin\QuestionTemplateController@Create')->name('createQuestionTemplate');
    Route::post('/admin/question_templates/order', 'Admin\QuestionTemplateController@updateOrder')->name('admin/question_templates/order');
    Route::post('/admin/question_templates/addQuestion', 'Admin\QuestionTemplateController@addQuestionToTemplate')->name('addQuestionToTemplate');

    Route::post('/admin/availability', 'Admin\CallController@getAvailable')->name('getAvailable');
    Route::post('/admin/calls/assign', 'Admin\CallController@assign')->name('assignCall');
    Route::post('/admin/calls/mass-assign', 'Admin\CallController@multiAssign')->name('assignCalls');
    Route::post('/admin/schedule/create', 'Admin\ScheduleController@create')->name('createSchedule');
    Route::post('/admin/schedule/modify', 'Admin\ScheduleController@modify')->name('modifySchedule');
});
