<?php

namespace App\Providers;

use App\Models\Job;
use App\Policies\JobPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider  extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    protected $policies = [
        Job::class => JobPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
