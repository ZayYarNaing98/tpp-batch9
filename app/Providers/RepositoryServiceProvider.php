<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);

        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);

        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);

    }
}
