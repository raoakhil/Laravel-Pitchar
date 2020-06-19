<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/_post_marker','PostMarkerController@postMarker')->name('marker.post');
Route::post('/_fetch_marker','PostMarkerController@fetchMarker')->name('marker.fetch');
Route::post('/_post_pattern','PostPatternController@postPattern')->name('pattern.post');
