<?php

namespace App\Policies;

use App\User;
use App\GuardianExchange;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class GuardianExchangePolicy
{
    use HandlesAuthorization;

    public function show(User $user, GuardianExchange $exchange)
    {
        return $exchange->new_guardian == $user->id;
    }

    public function list(User $user)
    {
        // Any user can list its own cards
        return true;
    }

    public function create(User $user)
    {
        // only a guardian can request a new exchange
        return Auth::check() && $user->is_responsible && $user->is_guardian;
    }
}
