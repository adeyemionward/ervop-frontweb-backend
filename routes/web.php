<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

Route::group(['prefix' => '/website', 'as' => 'website.'], function () {
    Route::get('/', [WebsiteController::class, 'index'])->name('index');
    Route::get('/about', [WebsiteController::class, 'about'])->name('about');
    Route::get('/appointment', [WebsiteController::class, 'appointment'])->name('appointment');
    Route::get('/services', [WebsiteController::class, 'services'])->name('services');
    Route::get('/service_detail', [WebsiteController::class, 'service_detail'])->name('service_detail');

    Route::get('/shop', [WebsiteController::class, 'shop'])->name('shop');
    Route::get('/product_detail', [WebsiteController::class, 'product_detail'])->name('product_detail');
    Route::get('/product_link', [WebsiteController::class, 'product_link'])->name('product_link');
    Route::get('/project_link', [WebsiteController::class, 'project_link'])->name('project_link');

    Route::get('/whyus', [WebsiteController::class, 'whyus'])->name('whyus');
    Route::get('/terms', [WebsiteController::class, 'terms'])->name('terms');
    Route::get('/privacy', [WebsiteController::class, 'privacy'])->name('privacy');
    Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
    Route::get('/faq', [WebsiteController::class, 'faq'])->name('faq');
    Route::get('/portfolio', [WebsiteController::class, 'portfolio'])->name('portfolio');

});
