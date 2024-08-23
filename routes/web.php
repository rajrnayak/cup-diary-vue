<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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


Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login-post',[AuthController::class,'loginPost'])->name('login_post');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/test-page',[DashboardController::class,'TestPage'])->name('test_page');
Route::middleware(['auth'])->group(function () {

    Route::get('/',[DashboardController::class,'index'])->name('index');

    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');

        Route::post('store-or-update/{user?}', [UserController::class, 'storeOrUpdate'])->name('store_or_update');

        Route::get('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');

        Route::post('load-data', [UserController::class, 'loadData'])->name('load_data');
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });
});
