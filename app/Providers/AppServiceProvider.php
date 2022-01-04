<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /**
         * Diretivas
         * 
         * Example:
         * @tenant
         *  <html code>
         * @endtenant
        */

        //Caso não for o dominio principal, retorna true.
        Blade::if('tenant', function () {
            return request()->getHost() != config('tenant.domain_main');
        });

        //Caso for o dominio principal, retorna true e exibe o conteudo.
        Blade::if('tenantmain', function () {
            return request()->getHost() == config('tenant.domain_main');
        });
    }
}
