<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AddressController;

Route::get('/users', [UserController::class, 'index']); 
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::resource('clients', ClientController::class);

Route::resource('addresses', AddressController::class)->except([
  'destroy'
]);