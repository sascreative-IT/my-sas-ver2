<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\FileRepositoryInterface',
            'App\Repositories\FileRepository'
        );
        $this->app->bind(
            'App\Repositories\CustomerRepositoryInterface',
            'App\Repositories\CustomerRepository'
        );
        $this->app->bind(
            'App\Repositories\CsAgentRepositoryInterface',
            'App\Repositories\CsAgentRepository'
        );
        $this->app->bind(
            'App\Repositories\SalesAgentRepositoryInterface',
            'App\Repositories\SalesAgentRepository'
        );
        $this->app->bind(
            'App\Repositories\CustomerContactRepositoryInterface',
            'App\Repositories\CustomerContactRepository'
        );
        $this->app->bind(
            'App\Repositories\AddressRepositoryInterface',
            'App\Repositories\AddressRepository'
        );
        $this->app->bind(
            'App\Repositories\StyleCodeRepositoryInterface',
            'App\Repositories\StyleCodeRepository'
        );
        $this->app->bind(
            'App\Repositories\OrderRepositoryInterface',
            'App\Repositories\OrderRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
