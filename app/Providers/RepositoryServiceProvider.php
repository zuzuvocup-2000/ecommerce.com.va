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
        'App\Repositories\Interfaces\BrandRepositoryInterface' => 'App\Repositories\BrandRepository',
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
