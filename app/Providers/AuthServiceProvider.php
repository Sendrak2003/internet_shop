<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Orders;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Orders::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-order', [OrderPolicy::class,'create']);
        Gate::define('view-order', [OrderPolicy::class,'view']);
        Gate::define('update-order', [OrderPolicy::class,'update']);
        Gate::define('delete-order', [OrderPolicy::class,'delete']);
    }
}
