<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $models = [
            'User',
        ];

        foreach ($models as $model)
        {
            $namespaces = [
                "App\Interfaces\\{$model}RepositoryInterface",
                "App\Repositories\\{$model}Repository"
            ];

            $this->app->bind(...$namespaces);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
