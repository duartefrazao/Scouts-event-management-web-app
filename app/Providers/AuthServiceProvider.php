<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Event' => 'App\Policies\EventPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'App\Group' => 'App\Policies\GroupPolicy',
        'App\Option' => 'App\Policies\OptionPolicy',
        'App\Vote' => 'App\Policies\VotePolicy',
        'App\Poll' => 'App\Policies\PollPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\GuardianExchange' => 'App\Policies\GuardianExchangePolicy',
        'App\RegistrationRequest' => 'App\Policies\RegistrationRequestPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
