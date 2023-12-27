<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


// welcome page
Route::get('/', function () {
    return view('welcome');
});

// auth middleware

// Home controller methods
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
});

//Auth controller method
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('admin.auth.logout');
});

// User controller methods
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('/user', [UserController::class, 'index'])->name('admin.user.get');
    Route::get('/user/update/{id}', [UserController::class, 'edit'])->name('admin.user.edit');

    Route::post('/user/create', [UserController::class, 'store'])->name('admin.user.post');
    Route::post('logout', [AuthController::class, 'destroy'])->name('admin.auth.logout');

    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('admin.user.put');
    Route::put('/user/change-password/{id}', [UserController::class, 'changePassword'])->name('admin.user.change.password');
    Route::put('/user/change-active/{id}', [UserController::class, 'changeActive'])->name('admin.user.change.active');

    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
});




// guest middleware
// get methods
Route::group(['prefix' => 'admin', 'middleware' => ['guest']], function () {
    Route::get('login', [AuthController::class, 'index'])->name('admin.auth.login.get');
});

// post methods
Route::group(['prefix' => 'admin', 'middleware' => ['guest']], function () {
    Route::post('login', [AuthController::class, 'create'])->name('admin.auth.login.post');
});