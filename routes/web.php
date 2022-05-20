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
use App\Actions\Product\GetCartTotal;
use App\Actions\Product\GetPaymentMethods;
use App\Actions\Product\SetCart;
use App\Actions\Product\GetWaypoints;
use App\Actions\Product\SingleCharge;
use App\Actions\Product\GetOrdersDetails;
use App\Actions\Product\GetOrderProducts;

use App\Actions\Partnership\CreatePartnership;
use App\Actions\Partnership\EditPartnership;
use App\Actions\Partnership\GetPartnershipsDetails;
use App\Actions\Partnership\GetPartnershipProductsList;

use App\Actions\User\SetUserActivation;
use App\Actions\User\SetUserRole;

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

Route::patch('/user/{id}/activation', SetUserActivation::class)->middleware('admin')->name('user.edit.activation');
Route::patch('/user/{id}/role', SetUserRole::class)->middleware('admin')->name('user.edit.role');

Route::get('/forgot-password', [Authentication::class, 'forgotPassword'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [Authentication::class, 'forgotPasswordSubmit']);

Route::get('/reset-password/{token}', [Authentication::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [Authentication::class, 'resetPasswordSubmit'])->middleware('guest')->name('password.resetSubmit');

Route::get('/catalogue', [Catalogue::class, 'index'])->middleware('auth')->name('catalogue');

Route::get('/cart', [Panier::class, 'index'])->middleware('auth')->name('cart');
Route::post('/cart/add', AddToCart::class)->middleware('auth')->name('cart.add');
Route::post('/cart/set', SetCart::class)->middleware('auth')->name('cart.set');
Route::post('/cart/payment', SingleCharge::class)->middleware('auth')->name('cart.payment');
Route::get('/cart/total', GetCartTotal::class)->middleware('auth')->name('cart.total');

Route::post('/pay/package', SingleCharge::class)->middleware('auth')->name('cart.payment');

// Route::get('/user/paymentmethods', GetPaymentMethods::class)->middleware('auth')->name('user.payment.methods');

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/stripe-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('index'));
})->name('dashboard.stripe-portal');

Route::get('/dashboard/orders', [Dashboard::class, 'orders'])->middleware('auth')->name('user.orders');

Route::get('/dashboard/weather', [Dashboard::class, 'weather'])->middleware('auth')->name('dashboard_weather');

Route::get('/dashboard/packages', [Dashboard::class, 'packages'])->middleware('auth')->name('user.packages');
Route::post('/dashboard/admin/orders/details', GetOrdersDetails::class)->middleware("auth")->name('users.details');
Route::get('/dashboard/admin/orders/{orderId}/content', GetOrderProducts::class)->middleware('auth')->name('user.orders.content');

Route::get('/dashboard/admin/accounts', [Dashboard::class, 'accounts'])->middleware("admin")->name('admin.accounts');
Route::get('/dashboard/admin/scooters', [Dashboard::class, 'scooter'])->middleware("admin")->name('admin.scooters');
Route::get('/dashboard/admin/products', [Dashboard::class, 'products'])->middleware("admin")->name('admin.products');
Route::get('/dashboard/admin/partnerships', [Dashboard::class, 'partnerships'])->middleware("admin")->name('admin.partnerships');
Route::post('/dashboard/admin/partnerships', CreatePartnership::class)->middleware("admin")->name('admin.partnerships');
Route::put('/dashboard/admin/partnerships/{id}', EditPartnership::class)->middleware("admin")->name('admin.partnerships.edit');
Route::get('/dashboard/admin/partnerships/{id}/list', GetPartnershipProductsList::class)->middleware("admin")->name('admin.partnerships.list');
Route::post('/dashboard/admin/partnership/details', GetPartnershipsDetails::class)->middleware("admin")->name('admin.products.details');

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
