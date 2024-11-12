<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Tenant\Company;

class DatabaseConfigServiceProvider extends ServiceProvider
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
        $config = Company::first();

        if ($config) {
            config([
                'database.connections.sqlsrv.driver' => $config->server_driver,
                'database.connections.sqlsrv.url' => $config->server_url,
                'database.connections.sqlsrv.host' => $config->server_host,
                'database.connections.sqlsrv.port' => $config->server_port,
                'database.connections.sqlsrv.database' => $config->server_database,
                'database.connections.sqlsrv.username' => $config->server_username,
                'database.connections.sqlsrv.password' => $config->server_password,
                'database.connections.sqlsrv.charset' => $config->server_charset,
                'database.connections.sqlsrv.prefix' => $config->server_prefix,
                'database.connections.sqlsrv.prefix_indexes' => $config->server_prefix_indexes,
            ]);
        }
    }
}
