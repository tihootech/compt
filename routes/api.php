<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('baseinfo', 'BaseInfoController@getData');
Route::post('baseinfo/{type}/{id?}', 'BaseInfoController@upsertData');
Route::post('baseinfo/salon/places/{salon}', 'BaseInfoController@mangePlaces');
Route::delete('baseinfo/{type}/{id}', 'BaseInfoController@deleteData');


Route::post('course/upsert/{course?}', 'CourseController@upsert');
Route::post('course/init/{course}', 'CourseController@init');
Route::get('courses/{filter?}', 'CourseController@index');
Route::get('calendar/sessions/{week?}', 'ScheduleController@calendarSessions');
