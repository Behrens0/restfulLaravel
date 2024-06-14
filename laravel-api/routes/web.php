<?php
namespace App\Http\Controllers\Api\V2;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RegionController;
use App\Http\Controllers\Api\V1\CommuneController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Middleware\middleware_region;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\MiddlewareCommune;
use App\Http\Middleware\MiddlewareCreateCustomer;
use App\Http\Middleware\middlewareDelete;
use App\Http\Middleware\Register;
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
    Route::delete('customer', [CustomerController::class, 'destroy']);
    Route::get('customer', [CustomerController::class, 'show']);
    // Other routes...
});
Route::post('/region', [RegionController::class, 'store'])->name('region.store')->middleware(middleware_region::class);
Route::post('/commune', [CommuneController::class, 'store'])->name('commune.store')->middleware(MiddlewareCommune::class);
Route::post('customer', [CustomerController::class, 'store'])->middleware(MiddlewareCreateCustomer::class);
Route::get('customer/{identifier}', [CustomerController::class, 'show'])->middleware(MiddlewareShow::class);
Route::delete('customer/{email}', [CustomerController::class, 'destroy'])->middleware(middlewareDelete::class);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');

Route::get('/main', "App\Http\Controllers\Api\V1\RegionController@index")->name("main");
Route::middleware(['auth'])->group(function () {
    Route::get('/main', "App\Http\Controllers\Api\V1\RegionController@index")->name('main');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');
});

Route::middleware(['bearerMiddleware'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout1');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware(Register::class);

Route::get('/login1', "App\Http\Controllers\Api\V2\AuthController@showLoginForm")->name('login1');
Route::post('/login2', [AuthController::class, 'login'])->name('login.process')->middleware(MiddlewareToken::class);

