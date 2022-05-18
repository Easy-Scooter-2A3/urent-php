<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Weather;
use App\Http\Controllers\Panier;
use App\Http\Controllers\Catalogue;
use App\Actions\Authentication\ResetPassword;
use App\Http\Controllers\ScooterController;
use Illuminate\Http\Request;
use App\Actions\Package\EditUserPackage;
use App\Actions\Product\CreateProduct;
use App\Actions\Product\EditProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\GetProductsDetails;
use App\Actions\Product\AddToCart;
use App\Actions\Product\GetPaymentMethods;
use App\Actions\Product\SetCart;
use App\Actions\Product\GetWaypoints;
use App\Actions\Product\SingleCharge;


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

Route::get('/catalogue', [Catalogue::class, 'index'])->middleware('auth')->name('catalogue');

Route::get('/cart', [Panier::class, 'index'])->middleware('auth')->name('cart');
Route::post('/cart/add', AddToCart::class)->middleware('auth')->name('cart.add');
Route::post('/cart/set', SetCart::class)->middleware('auth')->name('cart.set');
Route::post('/cart/payment', SingleCharge::class)->middleware('auth')->name('cart.payment');

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/stripe-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('index'));
})->name('dashboard.stripe-portal');

Route::get('/dashboard/weather', [Dashboard::class, 'weather'])->middleware('auth')->name('dashboard_weather');

Route::get('/dashboard/packages', [Dashboard::class, 'packages'])->middleware('auth')->name('user.packages');

Route::get('/dashboard/admin/accounts', [Dashboard::class, 'accounts'])->middleware("admin")->name('admin.accounts');
Route::get('/dashboard/admin/scooters', [Dashboard::class, 'scooter'])->middleware("admin")->name('admin.scooters');
Route::get('/dashboard/admin/products', [Dashboard::class, 'products'])->middleware("admin")->name('admin.products');

Route::get('/weather', [Weather::class, 'list'])->middleware('admin')->name('weather');

Route::post('/dashboard/packages/edit', EditUserPackage::class)->middleware('auth')->name('user.packages.edit');

Route::post('/dashboard/admin/users/action', [Dashboard::class, 'action'])->middleware("admin")->name('admin.users.action');
Route::post('/dashboard/admin/users/details', [Dashboard::class, 'details'])->middleware("admin")->name('admin.users.details');

Route::post('/dashboard/admin/scooters/action', [ScooterController::class, 'action'])->middleware("admin")->name('admin.scooters.action');
Route::post('/dashboard/admin/scooters/details', [ScooterController::class, 'details'])->middleware("admin")->name('admin.scooters.details');

Route::post('/dashboard/admin/products', CreateProduct::class)->middleware("admin")->name('admin.products.create');
Route::put('/dashboard/admin/products/{id}', EditProduct::class)->middleware("admin")->name('admin.products.edit');
Route::post('/dashboard/admin/products/delete', DeleteProduct::class)->middleware("admin")->name('admin.products.delete');
Route::post('/dashboard/admin/products/details', GetProductsDetails::class)->middleware("admin")->name('admin.products.details');


Route::get('/getwaypoints', GetWaypoints::class)->middleware('auth')->name('getwaypoints');
