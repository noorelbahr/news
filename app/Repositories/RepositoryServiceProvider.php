<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRepositories();
    }

    /**
     * Bind repositories
     */
    protected function bindRepositories()
    {
        $models = [
            'Category',
            'News',
            'User',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "App\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "App\\Repositories\\Eloquent\\{$model}Repository"
            );
        }
    }
}
