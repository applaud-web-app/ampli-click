<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Extensions\DatabaseSessionHandler;
use DB,Session;
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
        Paginator::useBootstrap();
        Session::extend('DHLMS_SESSION', function ($app) {
            $table   = config('session.table');
            $minutes = config('session.lifetime');
            return new DatabaseSessionHandler($this->getDatabaseConnection(), $table, $minutes, $app);
        });
    }

    protected function getDatabaseConnection()
    {
        $connection = config('session.connection');

        return DB::connection($connection);
    }
}
