<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public $bindings = [
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',
        'App\Repositories\Interfaces\BrandRepositoryInterface' => 'App\Repositories\BrandRepository',
        'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',
        'App\Repositories\Interfaces\RoutesRepositoryInterface' => 'App\Repositories\RoutesRepository',
        'App\Repositories\Interfaces\AuthRepositoryInterface' => 'App\Repositories\AuthRepository',
    ];

   public function register()
   {
        foreach($this->bindings as $key => $val)
        {
            $this->app->bind($key, $val);
        }
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
