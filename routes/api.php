<?php

use App\Http\Controllers\AddStudentViaEmailController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PresentController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\StudentController;
use App\Models\Classroom;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('sign-in-user', function () {
        return auth()->user();
    });
    Route::post('add-student-email', AddStudentViaEmailController::class);
    Route::apiResource('classrooms', ClassroomController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('records', RecordController::class);
    Route::apiResource('presents', PresentController::class);
});
