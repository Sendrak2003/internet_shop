<?php

use App\Http\Controllers\api\V1\AuthController;
use App\Http\Controllers\api\V1\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('orders', OrdersController::class)->only([
    'index', 'store', 'show', 'update'
])->names([
    'index' => 'api.orders.index',
    'store' => 'api.orders.store',
    'show' => 'api.orders.show',
    'update' => 'api.orders.update',
]);

Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('register', [AuthController::class, 'register'])->name('api.register');

Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('refresh', [AuthController::class,'refresh'])->name('api.refresh');
});
