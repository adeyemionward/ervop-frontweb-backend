<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Professionals\AppointmentController;
use App\Http\Controllers\API\Professionals\AppointmentNoteController;
use App\Http\Controllers\API\Professionals\ContactController;
use App\Http\Controllers\API\Professionals\DocumentController;
use App\Http\Controllers\API\Professionals\FormController;
use App\Http\Controllers\API\Professionals\FormSubmissionController;
use App\Http\Controllers\API\Professionals\InvoiceController;
use App\Http\Controllers\API\Professionals\InvoicePaymentController;
use App\Http\Controllers\API\Professionals\ProjectController;
use App\Http\Controllers\API\Professionals\ServiceController;
use App\Http\Controllers\API\Professionals\TransactionController;
use App\Http\Controllers\API\Professionals\Settings\AccountSettingController;
use App\Http\Controllers\API\Professionals\Settings\BusinessLocationSettingController;
use App\Http\Controllers\API\Professionals\Settings\BusinessProfileSettingController;
use App\Http\Controllers\API\Professionals\Settings\NotificationSettingController;
use App\Http\Controllers\API\Professionals\Settings\ProfileSettingController;
use App\Http\Controllers\API\Professionals\Settings\BusinessLogoController;

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

                        Route::get('getAvailableSlots', [AppointmentController::class, 'getAvailableSlots']);
                        Route::post('create', [AppointmentController::class, 'create']);
                        Route::get('list', [AppointmentController::class, 'index']);
                        Route::get('show/{appointment}', [AppointmentController::class, 'show']);
                        Route::get('clientAppointments/{contactId}', [AppointmentController::class, 'clientAppointments']);
                        Route::put('update/{id}', [AppointmentController::class, 'update']);
                        Route::delete('delete/{id}', [AppointmentController::class, 'delete']);
                        Route::get('showSetAvailability', [AppointmentController::class, 'showSetAvailability']);
                        Route::post('setAvailability', [AppointmentController::class, 'setAvailability']);
                        Route::post('updateStatus/{id}', [AppointmentController::class, 'updateStatus']);
                        Route::post('reschedule/{id}', [AppointmentController::class, 'reschedule']);
                        Route::post('uploadDocument', [AppointmentController::class, 'uploadDocument']);

                        Route::group(['prefix' => '/notes', 'as' => 'notes.'], function () {
                            Route::get('list/{appointment}', [AppointmentNoteController::class, 'index']);
                            Route::post('create/{appointment}', [AppointmentNoteController::class, 'store']);
                            Route::put('update/{note}', [AppointmentNoteController::class, 'update']);
                            Route::delete('delete/{note}', [AppointmentNoteController::class, 'destroy']);
                        });

                    });

                    Route::group(['prefix' => '/projects', 'as' => 'projects.'], function () {
                        Route::post('create', [ProjectController::class, 'create']);
                        Route::get('list', [ProjectController::class, 'index']);
                        Route::get('show/{id}', [ProjectController::class, 'show']);
                        Route::get('clientProjects/{contactId}', [ProjectController::class, 'clientProjects']);
                        Route::put('update/{id}', [ProjectController::class, 'update']);
                        Route::delete('delete/{id}', [ProjectController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/documents', 'as' => 'documents.'], function () {
                        Route::post('create', [DocumentController::class, 'create']);
                        Route::get('list', [DocumentController::class, 'index']);
                        Route::get('userDocs/{id}', [DocumentController::class, 'userDocs']);
                        Route::get('clientsWithDocs', [DocumentController::class, 'clientsWithDocs']);
                        Route::put('update/{id}', [DocumentController::class, 'update']);
                        Route::delete('delete/{id}', [DocumentController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/invoices', 'as' => 'invoices.'], function () {
                        Route::post('create', [InvoiceController::class, 'create']);
                        Route::get('list', [InvoiceController::class, 'index']);
                        Route::get('show/{invoice}', [InvoiceController::class, 'show']);
                        Route::put('update/{invoice}', [InvoiceController::class, 'update']);
                        Route::delete('delete/{invoice}', [InvoiceController::class, 'delete']);

                        Route::get('listPayment', [InvoicePaymentController::class, 'listPayment']);
                        Route::post('recordPayment/{invoice}', [InvoicePaymentController::class, 'recordPayment']);
                        Route::put('updatePayment/{payment}', [InvoicePaymentController::class, 'updatePayment']);
                        Route::get('showPayment/{payment}', [InvoicePaymentController::class, 'showPayment']);
                        Route::delete('deletePayment/{payment}', [InvoicePaymentController::class, 'deletePayment']);
                    });

                    Route::group(['prefix' => '/transactions', 'as' => 'transactions.'], function () {
                        Route::post('create', [TransactionController::class, 'create']);
                        Route::get('list', [TransactionController::class, 'index']);
                        Route::get('show/{id}', [TransactionController::class, 'show']);
                        Route::put('update/{id}', [TransactionController::class, 'update']);
                        Route::delete('delete/{id}', [TransactionController::class, 'delete']);

                        Route::get('listPayment', [InvoicePaymentController::class, 'listPayment']);
                        Route::post('createCategory/', [TransactionController::class, 'createCategory']);
                        Route::get('listCategory/', [TransactionController::class, 'listCategory']);
                        Route::get('showPayment/{payment}', [InvoicePaymentController::class, 'showPayment']);
                        Route::delete('deletePayment/{payment}', [InvoicePaymentController::class, 'deletePayment']);
                    });

                    Route::group(['prefix' => '/forms', 'as' => 'forms.'], function () {
                        Route::post('create', [FormController::class, 'create']);
                        Route::get('list', [FormController::class, 'index']);
                        Route::get('show/{form}', [FormController::class, 'show']);
                        Route::put('update/{form}', [FormController::class, 'update']);

                        Route::post('submitForm', [FormSubmissionController::class, 'submitForm']);
                        Route::get('listFormSubmissions/{form}', [FormSubmissionController::class, 'listFormSubmissions']);
                        Route::get('viewFormSubmissions/{submission}', [FormSubmissionController::class, 'viewFormSubmissions']);
                        Route::put('updateFormSubmissions/{submission}', [FormSubmissionController::class, 'updateFormSubmissions']);
                        Route::delete('delete/{id}', [FormController::class, 'delete']);
                    });

                    Route::group(['prefix' => '/settings', 'as' => 'settings.'], function () {
                        Route::put('profile/update', [ProfileSettingController::class, 'update']);
                        Route::put('businessProfile/update', [BusinessProfileSettingController::class, 'update']);
                        Route::put('location/update', [BusinessLocationSettingController::class, 'update']);
                        Route::post('logo/update', [BusinessLogoController::class, 'update']);
                        Route::put('notification/update', [NotificationSettingController::class, 'update']);
                        Route::put('account/update', [AccountSettingController::class, 'update']);
                    });
                });
            });
        });
    });
