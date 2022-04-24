<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Weather;
use App\Actions\Authentication\ResetPassword;
use App\Http\Controllers\ScooterController;
use Illuminate\Http\Request;


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

Route::get('/', [Index::class, 'index'])->name('index');
Route::get('/logout', [Index::class, 'logout']);

Route::get('/forgot-password', [Authentication::class, 'forgotPassword'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [Authentication::class, 'forgotPasswordSubmit']);

Route::get('/reset-password/{token}', [Authentication::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [Authentication::class, 'resetPasswordSubmit'])->middleware('guest')->name('password.resetSubmit');

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/stripe-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('index'));
})->name('dashboard.stripe-portal');

Route::get('/dashboard/weather', [Dashboard::class, 'weather'])->middleware('auth')->name('dashboard_weather');

Route::get('/dashboard/admin/accounts', [Dashboard::class, 'accounts'])->middleware("admin")->name('admin.accounts');
Route::get('/dashboard/admin/scooters', [Dashboard::class, 'scooter'])->middleware("admin")->name('admin.scooters');
Route::get('/weather', [Weather::class, 'list'])->middleware('admin')->name('weather');

Route::post('/dashboard/admin/users/action', [Dashboard::class, 'action'])->middleware("admin")->name('admin.users.action');
Route::post('/dashboard/admin/users/details', [Dashboard::class, 'details'])->middleware("admin")->name('admin.users.details');

Route::post('/dashboard/admin/scooters/action', [ScooterController::class, 'action'])->middleware("admin")->name('admin.scooters.action');
Route::post('/dashboard/admin/scooters/details', [ScooterController::class, 'details'])->middleware("admin")->name('admin.scooters.details');
