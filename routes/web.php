<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\EventsController;
use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\admin\EmailController;
use App\Http\Controllers\admin\WhatsAppController;
use App\Http\Controllers\public\PagesController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\QrCodeController;
use App\Http\Controllers\admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class , 'home'])->name('home');
Route::get('/about', [PagesController::class , 'about'])->name('about');
Route::get('/services', [PagesController::class , 'services'])->name('services');
Route::get('/projects', [PagesController::class , 'projects'])->name('projects');
Route::get('/gallery', [PagesController::class , 'gallery'])->name('gallery');
Route::get('/contact', [PagesController::class , 'contact'])->name('contact');

// Subscription routes
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class , 'login'])->name('admin-login');
    Route::post('/', [AuthController::class , 'login_request'])->name('login-request');
    Route::get('/logout', [AuthController::class , 'logout'])->name('admin-logout');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPassword'])->name('admin.forgot-password.send');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('admin.password.reset');
    Route::post('/resetting-password', [AuthController::class, 'updatePassword'])->name('admin.password.update');
     // Protected Routes
    Route::middleware('auth:admin')->group(function () {
         // Admin Dashboard - only accessible by admin users
        Route::get('/dashboard', [DashboardController::class , 'dashboard'])->name('admin-dashboard')->middleware('admin.only');
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');        
    });
 
});