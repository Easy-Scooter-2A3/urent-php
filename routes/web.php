<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Actions\Authentication\ResetPassword;
use App\Http\Controllers\AdminDashboard;


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