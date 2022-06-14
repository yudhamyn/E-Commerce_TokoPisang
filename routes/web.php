<?php

use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Middleware\AuthAccess;
use App\Http\Middleware\PageAccess;
use App\Http\Middleware\RoleAccessAdmin;
use App\Http\Middleware\RoleAccessUser;
use App\Http\Middleware\VerifAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

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

Route::middleware(AuthAccess::class)->group(function(){

    Route::get('login', function(){
        return view('auth.login');
    })->name('auth.login');
    
    Route::get('register', function(){
        return view('auth.register');
    })->name('auth.register');

});

Route::middleware(AuthAccess::class)->group(function(){

    Route::get('login', function(){
        return view('auth.login');
    })->name('auth.login');
    
    Route::get('register', function(){
        return view('auth.register');
    })->name('auth.register');

});


Route::middleware(VerifAccess::class)->group(function(){
    Route::get('', function(){
        return view('home');
    });
});

Route::middleware(PageAccess::class)->group(function(){

    Route::middleware(RoleAccessAdmin::class)->prefix('admin')->group(function(){

        Route::get('', function(){
            return redirect('admin/dashboard');
        })->name('admin');
        
        Route::get('dashboard', function(){
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::get('transactions', function(){
            return view('admin.transactions');
        })->name('admin.transactions');

        Route::get('transactions/export', [TransactionController::class,'export'])->name('admin.transactions.export');
        
        Route::get('products', function(){
            return view('admin.products');
        })->name('admin.products');

        Route::get('chats', function(){
            return view('chat');
        })->name('admin.chats');
        
        Route::get('user-management', function(){
            return view('admin.user-management');
        })->name('admin.user-management');

    });
    
    Route::middleware(RoleAccessUser::class)->group(function(){
        
        Route::prefix('user')->group(function(){

            Route::get('', function(){
                return redirect('user/transactions');
            })->name('user');

            Route::get('transactions', function(){
                return view('user.transactions');
            })->name('user.transactions');
    
            Route::get('chats', function(){
                return view('chat');
            })->name('user.chats');
        });


        Route::get('cart', function(){
            return view('cart');
        })->name('user.cart');
        
        Route::get('checkout', function(){
            return view('checkout');
        })->name('user.checkout');

    });

    Route::get('logout', function(){
        Auth::logout();
        Cookie::queue(Cookie::forget('_token'));
        return redirect('');
    });

});