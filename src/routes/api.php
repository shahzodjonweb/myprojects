<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DriverAuthController;
use App\Http\Controllers\ApiController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/change_password', [DriverAuthController::class, 'change_password']);
    Route::post('/login', [DriverAuthController::class, 'login']);
    Route::post('/logout', [DriverAuthController::class, 'logout']);
    Route::post('/refresh', [DriverAuthController::class, 'refresh']);
    Route::get('/user-profile', [DriverAuthController::class, 'userProfile']);     
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'load'

], function ($router) {
    Route::post('/get_location', [ApiController::class, 'getLocation']);
    Route::post('/get_load', [ApiController::class, 'getLoad']); 
    Route::post('/loadlist', [ApiController::class, 'getLoadList']); 
    Route::post('/change_status', [ApiController::class, 'changeLoad']); 
    // Route::post('/get_load', [ApiController::class, 'getLoad']); 
    // Route::post('/get_load', [ApiController::class, 'getLoad']); 

});
