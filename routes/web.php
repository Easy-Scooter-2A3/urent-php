<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Weather;
use App\Actions\Authentication\ResetPassword;
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
Route::get('/dashboard/weather', [Dashboard::class, 'weather'])->middleware('auth')->name('dashboard_weather');

Route::get('/weather', [Weather::class, 'list'])->middleware('auth')->name('weather');

Route::get('/scooter', [ScooterController::class, 'list'])->name('scooter_list');
Route::get('/scooter/{id}', [ScooterController::class, 'get'])->name('scooter');
Route::delete('/scooter/{id}', [ScooterController::class, 'delete'])->name('scooter_delete');
Route::post('/scooter', [ScooterController::class, 'insert'])->name('scooter_create');