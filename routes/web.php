<?php

use Illuminate\Support\Facades\Route;
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

            Route::get(LaravelLocalization::transRoute('routes.list-clients'),
                \App\Livewire\Panel\Clients\ListClients::class)
                ->name('panel.clients');
            Route::get(LaravelLocalization::transRoute('routes.create-client'),
                \App\Livewire\Panel\Clients\EditClient::class)
                ->name('panel.clients.create');
            Route::get(LaravelLocalization::transRoute('routes.edit-client'),
                \App\Livewire\Panel\Clients\EditClient::class)
                ->name('panel.clients.edit');
        });

        Route::get('login', function (){
            return redirect(route('home'))->with(['login'=>true]);
        })->name('login');

    });

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle)
        ->prefix(LaravelLocalization::setLocale());
});
