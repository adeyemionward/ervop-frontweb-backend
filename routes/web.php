<?php

use App\Http\Controllers\ClientPortal\Project\AccessController;
use App\Http\Controllers\ClientPortal\Project\DocumentController;
use App\Http\Controllers\ClientPortal\Project\NoteController;
use App\Http\Controllers\ClientPortal\Project\OverviewController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\AI\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;


    Route::domain('{username}.localhost')
    ->middleware(['web', 'checkSubdomain'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/about', [HomeController::class, 'about'])->name('about');
        Route::get('/services', [HomeController::class, 'services'])->name('services');
        Route::get('/service/{serviceName}', [HomeController::class, 'serviceDetails'])->name('serviceDetails');
        Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
        Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
        Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
        Route::get('/scheduleAppointment', [HomeController::class, 'scheduleAppointment'])->name('scheduleAppointment');

        Route::get('/portal/project/{cprojectId}', [OverviewController::class, 'index'])->name('index');

        Route::group(['prefix' => '/documents', 'as' => 'documents.'], function () {
            Route::post('newDocument/{cprojectId}', [DocumentController::class, 'newDocument'])->name('newDocument');
            // Route::get('list', [DocumentController::class, 'index']);
            // Route::get('userDocs/{id}', [DocumentController::class, 'userDocs']);
            // Route::get('clientsWithDocs', [DocumentController::class, 'clientsWithDocs']);
            // Route::put('update/{id}', [DocumentController::class, 'update']);
            // Route::delete('delete/{id}', [DocumentController::class, 'delete']);

            Route::get('/projects/{cprojectId}/partial', [DocumentController::class, 'reloadDocuments'])->name('reload');

        });

        Route::group(['prefix' => '/notes', 'as' => 'notes.'], function () {
            Route::post('newNote/{cprojectId}', [NoteController::class, 'newNote'])->name('newNote');
            Route::get('/projects/{cprojectId}/partial', [NoteController::class, 'reloadNotes'])->name('reload');
        });

        Route::post('/portal/verify-access', [AccessController::class, 'verify']);
        // Check access (AJAX)
        Route::get('/portal/check-access', function () {
            return response()->json(['access' => session('portal_portal_access') ?? false]);
        });
    });

    // Main domain routes (e.g., localhost)

    Route::middleware(['web'])->group(function () {
        Route::get('/', function () {
            return view('landingpage.index');
        });


    });



