<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\DoctorController;
use Illuminate\Support\Facades\Route;



//Login
Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    //Provider List
    Route::get('/provider-list', [DoctorController::class, 'providerList']);
    //Patient List
    Route::get('/patient-list', [DoctorController::class, 'patientList']);
    //Count total Patient
    Route::get('/total-patient', [DoctorController::class, 'countPatient']);
    //Add a new patient
    Route::post('/add-patient', [DoctorController::class, 'addPatient']);
    //Store Recording File
    Route::post('/store-file', [DoctorController::class, 'store']);
    //Recording List
    Route::post('/files', [DoctorController::class, 'fileList']);
    
});