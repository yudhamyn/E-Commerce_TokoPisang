<?php

namespace App\Http\Controllers\Api;

use App\Http\Middleware\ApiAccess;
use App\Http\Middleware\ApiAccessAdmin;
use App\Http\Middleware\ApiAccessUser;
use App\Http\Middleware\ApiVerif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware(ApiVerif::class)->group(function(){
    
    Route::get('product',[ProductController::class,'index']);
    
});

Route::middleware(ApiAccess::class)->group(function(){
    

    Route::middleware(ApiAccessAdmin::class)->prefix('admin')->group(function(){

        Route::get('/dashboard',[Admin\DashboardController::class,'index']);
        Route::get('/dashboard/transaction-product',[Admin\DashboardController::class,'transactionProduct']);

        Route::get('/transactions',[Admin\TransactionController::class,'index']);
        Route::put('/transaction/{id}/process',[Admin\TransactionController::class,'process']);
        Route::put('/transaction/{id}/reject',[Admin\TransactionController::class,'reject']);
        Route::put('/transaction/{id}/sent',[Admin\TransactionController::class,'sent']);

        Route::get('product',[Admin\ProductController::class,'index']);
        Route::delete('product/{id}',[Admin\ProductController::class,'destroy']);
        Route::post('product/{id}/update',[Admin\ProductController::class,'update']);
        Route::post('product',[Admin\ProductController::class,'store']);

        Route::get('user',[Admin\UserController::class,'index']);
        Route::delete('user/{id}',[Admin\UserController::class,'destroy']);
        Route::post('user/{id}/update',[Admin\UserController::class,'update']);
        Route::post('user',[Admin\UserController::class,'store']);

    });
    
    Route::middleware(ApiAccessUser::class)->group(function(){

        Route::get('cart',[CartController::class,'index']);
        Route::post('cart/checked/all',[CartController::class,'checked_all']);
        Route::post('cart/checked',[CartController::class,'checked']);
        Route::post('cart',[CartController::class,'store']);
        Route::put('cart/{id}',[CartController::class,'upQty']);
        Route::delete('cart/{id}',[CartController::class,'destroy']);

        Route::post('checkout',[CheckoutController::class,'index']);
        
        Route::get('user/transactions',[User\TransactionController::class,'index']);
        Route::put('user/transaction/{id}/cancel',[User\TransactionController::class,'cancel']);
        Route::put('user/transaction/{id}/received',[User\TransactionController::class,'received']);
        Route::put('user/transaction/{id}/finish',[User\TransactionController::class,'finish']);

    });

    Route::get('profile', [AuthController::class,'profile']);

    Route::prefix('chat')->group(function(){

        Route::get('',[ChatController::class,'index']);

        Route::post('message',[ChatController::class,'message']);

        Route::post('',[ChatController::class,'store']);

    });

});