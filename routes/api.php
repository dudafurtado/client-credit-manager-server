<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'store'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function() {
  Route::get('/users', [UserController::class, 'index']); 
  Route::get('/users/{user}', [UserController::class, 'show']);
  Route::put('/users/{user}', [UserController::class, 'update']);
  Route::delete('/users/{user}', [UserController::class, 'destroy']);

  Route::resource('clients', ClientController::class);

  Route::resource('addresses', AddressController::class)->except([
    'destroy'
  ]);

  Route::resource('cards', CardController::class)->except([
    'destroy'
  ]);

  Route::post('/logout/{user}', [AuthController::class, 'destroy'])->name('logout');
});
