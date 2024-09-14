<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use App\Models\Card;
use App\Models\Address;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
      Route::model('user', User::class);
      Route::model('client', Client::class);
      Route::model('card', Card::class);
      Route::model('address', Address::class);
    }
}
