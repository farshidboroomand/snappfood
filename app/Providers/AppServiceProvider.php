<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\V1\Users\Models\User;
use Modules\V1\Users\Observers\UserObserver;
use Modules\V1\Wallets\Models\Withdrawal;
use Modules\V1\Wallets\Observers\WithdrawalObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
    }
}
