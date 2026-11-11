<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ActivityPhotoController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentProgramController;
use Illuminate\Support\Facades\Route;

Route::apiResource('activities', ActivityController::class);
Route::post('activities/{activity}/photos', [ActivityPhotoController::class, 'store']);
Route::put('activities/{activity}/photos/{photo}', [ActivityPhotoController::class, 'update']);
Route::delete('activities/{activity}/photos/{photo}', [ActivityPhotoController::class, 'destroy']);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('locations', LocationController::class);
Route::apiResource('programs', ProgramController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('staffs', StaffController::class);
Route::apiResource('students', StudentController::class);
Route::post('students/{student}/programs', [StudentProgramController::class, 'store']);
Route::put('students/{student}/programs/{program}', [StudentProgramController::class, 'update']);
Route::delete('students/{student}/programs/{program}', [StudentProgramController::class, 'destroy']);
