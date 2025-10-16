<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\AI\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

// Route::group(['prefix' => '/website', 'as' => 'website.'], function () {
    // Route::get('/', [HomeController::class, 'home'])->name('home');
// });




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

    });

    // Main domain routes (e.g., localhost)

    Route::middleware(['web'])->group(function () {
        Route::get('/', function () {
            // Change this:
            // return 'Main site (localhost)';

            // To this:
            return view('landingpage.index');
        });
    });



