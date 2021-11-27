<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\MasterController;


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: token, Content-Type, x-xsrf-token, Accept, Authorization');
/*  header("Access-Control-Allow-Credentials", "true");*/
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
],function($router) {
    Route::get('fetchState',[MasterController::class,'fetchState'])->name('fetchState');
    Route::get('fetchCity',[MasterController::class,'fetchCity'])->name('fetchCity');
});
