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

            Route::get(LaravelLocalization::transRoute('routes.list-contracts'),
                \App\Livewire\Panel\Contracts\ListContracts::class)
                ->name('panel.contracts');
            Route::get(LaravelLocalization::transRoute('routes.create-contract'),
                \App\Livewire\Panel\Contracts\ContractForm::class)
                ->name('panel.contracts.create');
            Route::get(LaravelLocalization::transRoute('routes.edit-contract'),
                \App\Livewire\Panel\Contracts\ContractForm::class)
                ->name('panel.contracts.edit');

            Route::get(LaravelLocalization::transRoute('routes.list-gateways'),
                \App\Livewire\Panel\Gateways\ListGateways::class)
                ->name('panel.gateways');
            Route::get(LaravelLocalization::transRoute('routes.create-gateway'),
                \App\Livewire\Panel\Gateways\GatewayForm::class)
                ->name('panel.gateways.create');
            Route::get(LaravelLocalization::transRoute('routes.edit-gateway'),
                \App\Livewire\Panel\Gateways\GatewayForm::class)
                ->name('panel.gateways.edit');




        });

        Route::get('login', function (){
            return redirect(route('home'))->with(['login'=>true]);
        })->name('login');

    });

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle)
        ->prefix(LaravelLocalization::setLocale());
});
