<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Weather;
use App\Actions\Authentication\ResetPassword;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ScooterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Index::class, 'index']);
Route::get('/logout', [Index::class, 'logout']);

Route::get('/forgot-password', [Authentication::class, 'forgotPassword'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [Authentication::class, 'forgotPasswordSubmit']);

Route::get('/reset-password/{token}', [Authentication::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [Authentication::class, 'resetPasswordSubmit'])->middleware('guest')->name('password.resetSubmit');

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/admin', [AdminDashboard::class, 'index'])->middleware("admin")->name('admin');
Route::get('/admin-change', [AdminDashboard::class, 'changeAdmin'])->middleware("admin")->name('admin.change');
Route::get('/dashboard/weather', [Dashboard::class, 'weather'])->middleware('auth')->name('dashboard_weather');
Route::get('/weather', [Weather::class, 'list'])->middleware('auth')->name('weather');

Route::post('/admin/users/action', [AdminDashboard::class, 'action'])->middleware("auth")->name('admin.users.action');
Route::post('/admin/users/details', [AdminDashboard::class, 'details'])->middleware("auth")->name('admin.users.details');