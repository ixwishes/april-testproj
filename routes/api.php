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

/* todo app */
Route::middleware('auth:api')->get('/tasks', [
  'as' => 'tasks.index',
  'uses' => 'API\TaskController@index'
]);

Route::middleware('auth:api')->get('tasks/{id}', [
  'as' => 'tasks.show',
  'uses' => 'API\TaskController@show'
]);

Route::middleware('auth:api')->put('tasks/{id}', [
  'as' => 'tasks.update',
  'uses' => 'API\TaskController@update'
]);

Route::middleware('auth:api')->post('/tasks', [
  'as' => 'tasks.store',
  'uses' => 'API\TaskController@store'
]);

Route::middleware('auth:api')->delete('/tasks/{id}', [
  'as' => 'tasks.destroy',
  'uses' => 'API\TaskController@destroy'
]);

/* weather app */
Route::middleware('auth:api')->get('/weather', [
  'as' => 'weather.index',
  'uses' => 'API\WeatherController@index'
]);

Route::middleware('auth:api')->post('/weather/city', [
  'as' => 'weather.store',
  'uses' => 'API\WeatherController@store'
]);

Route::middleware('auth:api')->put('/weather/city/{id}', [
  'as' => 'weather.update',
  'uses' => 'API\WeatherController@update'
]);

Route::middleware('auth:api')->delete('/weather/city/{id}', [
  'as' => 'weather.destroy',
  'uses' => 'API\WeatherController@destroy'
]);
