<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Middleware\CheckUserOwnership;
use App\Http\Middleware\CheckClientOwnership;

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'store'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function() {
  Route::get('/users', [UserController::class, 'index']); 
  Route::get('/users/{user}', [UserController::class, 'show']);

  Route::middleware([CheckUserOwnership::class])->group(function () {
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
  });

  Route::resource('clients', ClientController::class);

  Route::scopeBindings()->middleware([CheckClientOwnership::class])->group(function () {
    Route::resource('clients.addresses', AddressController::class)->except(['update']);
  });

  Route::scopeBindings()->middleware([CheckClientOwnership::class])->group(function () {
    Route::get('/clients/{client}/cards', [CardController::class, 'index']);
    Route::post('/clients/{client}/cards', [CardController::class, 'store']);
    Route::get('/clients/{client}/cards/{card}', [CardController::class, 'show']);
    Route::put('/clients/{client}/cards/{card}', [CardController::class, 'update']);
    Route::delete('/clients/{client}/cards/{card}', [CardController::class, 'destroy']);
  });

  Route::post('/logout/{user}', [AuthController::class, 'destroy'])->name('logout');
});
