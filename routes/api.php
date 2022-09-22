<?php

use App\Http\Controllers\ShiftController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('schedule-shift', [ShiftController::class, 'scheduleEmployeeShift']);

Route::get('fetch-shift', [ShiftController::class, 'fetchEmployeeShift']);

Route::get('fetch-employee', [ShiftController::class, 'fetchEmployee']);

Route::post('fetch-individual-employee-shift-details', [ShiftController::class, 'fetchIndividualEmployeeShift']);

Route::get('fetch-employee-shift-details', [ShiftController::class, 'fetchEmployeeShift']);

Route::get('run-seeder', function () {

    \Artisan::call('db:seed --class=ShiftDurationSeeder');

    \Artisan::call('db:seed --class=UserSeeder');
});
