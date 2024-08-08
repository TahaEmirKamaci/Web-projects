<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Models\Record;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Anasayfa ve genel kayıt işlemleri
Route::get('/', [RecordController::class, 'index'])->name('form');
Route::post('/store', [RecordController::class, 'store'])->name('store');
Route::post('/checkout', [RecordController::class, 'checkout'])->name('checkout');

// Kayıt ve giriş işlemleri
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('RegistrationForm');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('loginForm');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Dashboard işlemleri
Route::get('/dashboard', [DashboardController::class, 'kullan'])->name('dashboard');
Route::get('/dashboard', [RecordController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware('auth')->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'Lara'])->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Kayıt ve yönetim paneli
Route::get('/record', [RecordController::class, 'record'])->name('record');

Route::get('/welcome', [RecordController::class, 'index'])->name('welcome');
