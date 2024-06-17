<?php
namespace App\Http\Controllers\Api\V2;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RegionController;
use App\Http\Controllers\Api\V1\CommuneController;
use App\Http\Middleware\middleware_region;
use App\Http\Middleware\MiddlewareCommune;
use App\Http\Middleware\MiddlewareCreateCustomer;
use App\Http\Middleware\middlewareDelete;
use App\Http\Middleware\Register;
use App\Http\Middleware\MiddlewareShow;
use App\Http\Middleware\MiddlewareToken;

Route::post('/region', [RegionController::class, 'store'])->name('region.store')->middleware(middleware_region::class);
Route::post('/commune', [CommuneController::class, 'store'])->name('commune.store')->middleware(MiddlewareCommune::class);
Route::post('customer', [CustomerController::class, 'store'])->middleware(MiddlewareCreateCustomer::class)->name("customer.store");
Route::get('customer/{identifier}', [CustomerController::class, 'show'])->middleware(MiddlewareShow::class);
Route::delete('customer/{email}', [CustomerController::class, 'destroy'])->middleware(middlewareDelete::class);

Route::get('/customer', [CustomerController::class, 'index'])->name("customer");


Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');

Route::get('/main', "App\Http\Controllers\Api\V1\RegionController@index")->name("main");

Route::middleware(['auth'])->group(function () {
    Route::get('/main', "App\Http\Controllers\Api\V1\RegionController@index")->name('main');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');
    Route::post('/commune', [CommuneController::class, 'store'])->name('commune.store')->middleware(MiddlewareCommune::class);
    Route::get('/customer', [CustomerController::class, 'index'])->name("customer");
    Route::post('customer', [CustomerController::class, 'store'])->middleware(MiddlewareCreateCustomer::class)->name("customer.store");
    Route::delete('customer/{email}', [CustomerController::class, 'destroy'])->middleware(middlewareDelete::class);
    Route::get('customer/{identifier}', [CustomerController::class, 'show'])->middleware(MiddlewareShow::class);
    Route::post('/region', [RegionController::class, 'store'])->name('region.store')->middleware(middleware_region::class);
});

Route::middleware(['bearerMiddleware'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');

    Route::post('/region', [RegionController::class, 'store'])->name('region.store')->middleware(middleware_region::class);
    Route::post('/commune', [CommuneController::class, 'store'])->name('commune.store')->middleware(MiddlewareCommune::class);

    Route::post('customer', [CustomerController::class, 'store'])->middleware(MiddlewareCreateCustomer::class)->name("customer.store");
    Route::delete('customer/{email}', [CustomerController::class, 'destroy'])->middleware(middlewareDelete::class);
    Route::get('customer/{identifier}', [CustomerController::class, 'show'])->middleware(MiddlewareShow::class);
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware(Register::class);

Route::get('/login1', "App\Http\Controllers\Api\V2\AuthController@showLoginForm")->name('login1');
Route::post('/login2', [AuthController::class, 'login'])->name('login.process')->middleware(MiddlewareToken::class);

