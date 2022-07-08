<?php

namespace App\Providers;

use App\Models\Model;
use Illuminate\Database\Eloquent\Model as ModelAlias;
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
        ModelAlias::unguard();

        if (app()->environment('local')) {
            app()->register('Arham\LLVT\LLVTServiceProvider');
        }
    }
}
