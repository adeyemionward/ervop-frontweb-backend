<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Professionals\AppointmentController;
use App\Http\Controllers\API\Professionals\ContactController;
use App\Http\Controllers\API\Professionals\DocumentController;
use App\Http\Controllers\API\Professionals\InvoiceController;
use App\Http\Controllers\API\Professionals\ProjectController;
use App\Http\Controllers\API\Professionals\ServiceController;

    Route::group(['middleware' => 'cors'], function ()
    {
        Route::prefix('v1')->group(function () {
            Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
                Route::post('login', [LoginController::class, 'login']);
                Route::post('register', [RegistrationController::class, 'register']);
                Route::post('secondStepValidation', [RegistrationController::class, 'secondStepValidation']);
                Route::post('otpVerification', [RegistrationController::class, 'otpVerification']);
            });

            Route::group(['middleware' => ['jwt']], function () {
                Route::group(['prefix' => '/professionals', 'as' => 'professionals.'], function () {
                    Route::group(['prefix' => '/services', 'as' => 'services.'], function () {
                        Route::post('create', [ServiceController::class, 'create']);
                        Route::get('list', [ServiceController::class, 'index']);
                        Route::get('show/{id}', [ServiceController::class, 'show']);
                        Route::put('update/{id}', [ServiceController::class, 'update']);
                        Route::delete('delete/{id}', [ServiceController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/contacts', 'as' => 'contacts.'], function () {
                        Route::post('create', [ContactController::class, 'create']);
                        Route::get('list', [ContactController::class, 'index']);
                        Route::get('show/{id}', [ContactController::class, 'show']);
                        Route::put('update/{id}', [ContactController::class, 'update']);
                        Route::delete('delete/{id}', [ContactController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/appointments', 'as' => 'appointments.'], function () {
                        Route::post('create', [AppointmentController::class, 'create']);
                        Route::get('list', [AppointmentController::class, 'index']);
                        Route::get('show/{id}', [AppointmentController::class, 'show']);
                        Route::put('update/{id}', [AppointmentController::class, 'update']);
                        Route::delete('delete/{id}', [AppointmentController::class, 'delete']);
                        Route::post('setAvailability', [AppointmentController::class, 'setAvailability']);
                    });

                    Route::group(['prefix' => '/projects', 'as' => 'projects.'], function () {
                        Route::post('create', [ProjectController::class, 'create']);
                        Route::get('list', [ProjectController::class, 'index']);
                        Route::get('show/{id}', [ProjectController::class, 'show']);
                        Route::put('update/{id}', [ProjectController::class, 'update']);
                        Route::delete('delete/{id}', [ProjectController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/documents', 'as' => 'documents.'], function () {
                        Route::post('create', [DocumentController::class, 'create']);
                        Route::get('list', [DocumentController::class, 'index']);
                        Route::get('show/{id}', [DocumentController::class, 'show']);
                        Route::put('update/{id}', [DocumentController::class, 'update']);
                        Route::delete('delete/{id}', [DocumentController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/invoices', 'as' => 'invoices.'], function () {
                        Route::post('create', [InvoiceController::class, 'create']);
                        Route::get('list', [InvoiceController::class, 'index']);
                        Route::get('show/{id}', [InvoiceController::class, 'show']);
                        Route::put('update/{id}', [InvoiceController::class, 'update']);
                        Route::delete('delete/{id}', [InvoiceController::class, 'delete']);
                    });
                });
            });
        });
    });
