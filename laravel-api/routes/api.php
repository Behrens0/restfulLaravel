<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Api/V1
// Route::group(['prefix'=> 'V1', "namespace" => "App\Http\Controllers\Api\V1"], function () {
//     Route::apiResource("customers", CustomerController::class);
//     Route::apiResource("regions", RegionController::class);
//     Route::apiResource("communes", CommuneController::class);
//     Route::apiResource("tokens", TokenController::class);
// });

// Route::group(['prefix' => 'customer'], function () {
//     Route::post('/', [CustomerController::class, 'store'])->middleware('storeMiddleware')->name('customer.store');
//     Route::get('{identifier}', [CustomerController::class, 'show'])->middleware('showMiddleware')->name('customer.show');
//     Route::delete('{email}', [CustomerController::class, 'destroy'])->middleware('destroyMiddleware')->name('customer.destroy');
// });
Route::middleware([MiddlewareUserToken::class])->group(function () {
    Route::post('commune', [CommuneController::class, 'store']);
    Route::post('login', [TokenController::class, 'store']);
    Route::resource('customer', CustomerController::class)->only(['store']);
    // Other routes...
});
Route::post('region', [RegionController::class, 'store'])->middleware(middleware_region::class);
Route::post('commune', [CommuneController::class, 'store'])->middleware(MiddlewareCommune::class);
Route::resource('customer', CustomerController::class)->except([
    'create', 'index', 'update', 'edit'
])->middleware([
    'customer.destroy' => middlewareDelete::class,
    'customer.show' => MiddlewareShow::class,
    'customer.store' =>MiddlewareCreateCustomer::class,
]);
Route::post('login', [TokenController::class, 'store'])->middleware(MiddlewareToken::class);