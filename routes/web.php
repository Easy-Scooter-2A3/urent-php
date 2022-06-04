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
use App\Actions\Product\GenerateInvoice;

use App\Actions\Partnership\CreatePartnership;
use App\Actions\Partnership\EditPartnership;
use App\Actions\Partnership\GetPartnershipsDetails;
use App\Actions\Partnership\GetPartnershipProductsList;

use App\Actions\User\SetUserActivation;
use App\Actions\User\SetUserRole;
use App\Actions\User\ConvertUserFidelity;

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

Route::get('/reset-password/{token}', [Authentication::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [Authentication::class, 'resetPasswordSubmit'])->middleware('guest')->name('password.resetSubmit');

Route::get('/dashboard/stripe-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('index'));
})->name('dashboard.stripe-portal');

Route::get('/dashboard/orders/pdf/{orderId}', GenerateInvoice::class)->middleware('auth')->name('user.pdf');

Route::get('/setlang/{lang}', function (Request $request) {
    $lang = $request->lang;
    $cookie = cookie('lang', $lang, 60 * 24 * 365);
    return redirect()->back()->withCookie($cookie);
})->name('setlang');

Route::get('/', [Index::class, 'index'])->name('index');
Route::get('/logout', [Index::class, 'logout']);
Route::get('/catalogue', [Catalogue::class, 'index'])->middleware('auth')->name('catalogue');

Route::post('/user/convertfidelity', ConvertUserFidelity::class)->middleware('auth')->name('user.convert.fidelity');
Route::patch('/user/{id}/activation', SetUserActivation::class)->middleware('admin')->name('user.edit.activation');
Route::patch('/user/{id}/role', SetUserRole::class)->middleware('admin')->name('user.edit.role');

Route::patch('/user/{id}/activation', SetUserActivation::class)->middleware('admin')->name('user.edit.activation');
Route::patch('/user/{id}/role', SetUserRole::class)->middleware('admin')->name('user.edit.role');

Route::get('/forgot-password', [Authentication::class, 'forgotPassword'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [Authentication::class, 'forgotPasswordSubmit']);

Route::post('/pay/package', SingleCharge::class)->middleware('auth')->name('package.payment');

Route::post('/dashboard/packages/edit', EditUserPackage::class)->middleware('auth')->name('user.packages.edit');

Route::group(['prefix' => 'cart'], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [Panier::class, 'index'])->name('cart');
        Route::post('/add', AddToCart::class)->name('cart.add');
        Route::post('/set', SetCart::class)->name('cart.set');
        Route::post('/payment', SingleCharge::class)->name('cart.payment');
        Route::get('/total', GetCartTotal::class)->name('cart.total');
    });
});

Route::controller(Dashboard::class)->group(function () {

    Route::get('/dashboard', 'index')->middleware('auth')->name('dashboard');
    

    Route::group(['prefix' => 'dashboard/admin'], function () {
        Route::middleware(['auth'])->group(function () {
            Route::get('/orders', 'orders')->name('dashboard.orders');
            Route::get('/packages', 'packages')->name('dashboard.packages');
            Route::get('/weather', 'weather')->name('dashboard.weather');
            Route::get('/packages', 'packages')->name('dashboard.packages');
        });
    });

    Route::group(['prefix' => 'dashboard/admin'], function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('/accounts', 'accounts')->name('admin.accounts');
            
            Route::group(['prefix' => 'scooters'], function () {
                Route::get('/', 'scooter')->name('admin.scooters');
                Route::post('/action', [ScooterController::class, 'action'])->name('admin.scooters.action');
                Route::post('/details', [ScooterController::class, 'details'])->name('admin.scooters.details');

                Route::post('/create', [ScooterController::class, 'create'])->middleware("admin")->name('admin.scooters.create');
                Route::post('/delete', [ScooterController::class, 'delete'])->middleware("admin")->name('admin.scooters.delete');
            });

            Route::group(['prefix' => 'products'], function () {
                Route::get('/', 'products')->name('admin.products');
                Route::post('/details', GetProductsDetails::class)->name('admin.products.details');
                Route::post('/', CreateProduct::class)->middleware("admin")->name('admin.products.create');
                Route::post('/{id}', EditProduct::class)->middleware("admin")->name('admin.products.edit');
                Route::post('/delete', DeleteProduct::class)->middleware("admin")->name('admin.products.delete');
            });

            Route::group(['prefix' => 'partnerships'], function () {
                Route::get('/', 'partnerships')->name('admin.partnerships');
                Route::post('/', CreatePartnership::class)->name('admin.partnerships.create');
                Route::put('/{id}', EditPartnership::class)->name('admin.partnerships.edit');
                Route::get('/{id}/list', GetPartnershipProductsList::class)->name('admin.partnerships.list');
                Route::post('/details', GetPartnershipsDetails::class)->name('admin.partnerships.details');
            });

            Route::group(['prefix' => 'orders'], function () { // TODO: check
                Route::post('/details', GetOrdersDetails::class)->name('users.details');
                Route::get('/{orderId}/content', GetOrderProducts::class)->name('user.orders.content');
            });

            Route::group(['prefix' => 'users'], function () {
                Route::post('/action', 'action')->name('admin.users.action');
                Route::post('/details', 'details')->name('admin.users.details');
            });
        });
    });
});

Route::get('/weather/{day}', [Weather::class, 'list'])->middleware('admin')->name('weather');
Route::get('/getwaypoints', GetWaypoints::class)->middleware('auth')->name('getwaypoints');