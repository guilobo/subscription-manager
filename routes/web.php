<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;




Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath']
    )
    ->group(function () {
        Route::get('/', \App\Livewire\Home::class)->name('home');

        Route::group(
            [
                'middleware' => [
                    'auth',
                    'can:access-admin-panel',
                ]], function () {

            Route::get(LaravelLocalization::transRoute('routes.panel'),
                \App\Livewire\Panel\HomePanel::class)
                ->name('panel.home');
        });

        Route::get('login', function (){
            return redirect(route('home'))->with(['login'=>true]);
        })->name('login');

    });

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle)
        ->prefix(LaravelLocalization::setLocale());
});
