<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AuthenticateController;
use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\LogoutController;
use App\Http\Controllers\Account\ProccessController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\UpdateProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('register', [AccountController::class, 'register'])->name('account.register');
        Route::post('register', [ProccessController::class, 'process'])->name('account.process');
        Route::get('login', [LoginController::class, 'login'])->name('account.login');
        Route::post('login', [AuthenticateController::class, 'authenticate'])->name('account.authenticate');
    });
   
    Route::group(['middleware' => 'auth'], function () {    
        Route::get('profile', [ProfileController::class, 'profile'])->name('account.profile');
        Route::get('logout', [LogoutController::class, 'logout'])->name('account.logout');
        Route::post('update-profile', [UpdateProfileController::class, 'update'])->name('account.update');
    });
   
});



// Route::get('account/profile', [ProfileController::class, 'profile'])->name('account.profile');


