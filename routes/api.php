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

    Route::post('/admin/question_templates/order', 'Admin\QuestionTemplateController@updateOrder')->name('admin/question_templates/order');
    Route::post('/admin/schedule/create', 'Admin\ScheduleController@create')->name('createSchedule');
    Route::post('/admin/schedule/modify', 'Admin\ScheduleController@modify')->name('modifySchedule');
});
