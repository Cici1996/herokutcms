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
Route::middleware('jwt.verify')->get('users', function(Request $request) {
    return auth()->user();
});

Route::post('users/register', 'APIRegisterController@register');
Route::post('users/login', 'APILoginController@login');
Route::get('chart/kelamin', 'APIChartController@ChartKelamin')->middleware('jwt.verify');
Route::get('chart/usia', 'APIChartController@ChartUsia')->middleware('jwt.verify');
Route::get('detail/lp/{id}', 'APIChartController@LpById')->middleware('jwt.verify');
Route::get('detail/lp', 'APIChartController@Lp')->middleware('jwt.verify');
Route::get('users/{id}', 'APIChartController@DetailUserData')->middleware('jwt.verify');