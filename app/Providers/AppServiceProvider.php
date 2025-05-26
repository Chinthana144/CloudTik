<?php

namespace App\Providers;

use App\Models\Customers;
use App\Models\User;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
            // Define your policies here
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
            Customers::class => CustomerPolicy::class,
        ];
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Paginator::useBootstrapFive();

        //role page access
        Gate::define('page_access', function (User $user, $page_id) {
            return $user->hasPageAccess($page_id);
        });
    }
}
