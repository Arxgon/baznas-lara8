<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\YearDataController;
use App\Http\Controllers\Api\AttendanceLeaderController;
use App\Http\Controllers\Api\RunningTextController;
use App\Http\Controllers\Api\AdsImageController;
use App\Http\Controllers\Api\VideoController;
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

Route::get('/year/{year}/monthly-collections', [YearDataController::class, 'getMonthlyCollections']);
Route::get('/year/{year}/monthly-distributions', [YearDataController::class, 'getMonthlyDistributions']);
Route::get('/years/{year}/monthly-data', [YearDataController::class, 'getMonthlyData']);
route::get('/attendance-leaders', [AttendanceLeaderController::class, 'index']);
route::get('/news', [RunningTextController::class, 'index']);
route::get('/ads', [AdsImageController::class, 'index']);
route::get('/vid', [VideoController::class, 'index']);
