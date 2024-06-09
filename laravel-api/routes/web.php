<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RegionController;
use App\Http\Controllers\Api\V1\CommuneController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Middleware\middleware_region;
use App\Http\Middleware\MiddlewareCommune;
use App\Http\Middleware\MiddlewareCreateCustomer;
use App\Http\Middleware\middlewareDelete;
use App\Http\Middleware\MiddlewareShow;
use App\Http\Middleware\MiddlewareUserToken;
use App\Http\Middleware\MiddlewareToken;
use App\Models\Customer;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::middleware([MiddlewareUserToken::class])->group(function () {
    Route::post('commune', [CommuneController::class, 'store']);
    Route::post('login', [TokenController::class, 'store']);
    Route::delete('customer', [CustomerController::class, 'destroy']);
    Route::get('customer', [CustomerController::class, 'show']);
    // Other routes...
});
Route::post('/region', [RegionController::class, 'store'])->name('region.store')->middleware(middleware_region::class);
Route::post('/commune', [CommuneController::class, 'store'])->name('commune.store')->middleware(MiddlewareCommune::class);
Route::post('customer', [CustomerController::class, 'store'])->middleware(MiddlewareCreateCustomer::class);
Route::get('customer/{identifier}', [CustomerController::class, 'show'])->middleware(MiddlewareShow::class);
Route::delete('customer/{email}', [CustomerController::class, 'destroy'])->middleware(middlewareDelete::class);

Route::post('login', [TokenController::class, 'store'])->middleware(MiddlewareToken::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/hola', function () {
    return view('InitialView');
});
