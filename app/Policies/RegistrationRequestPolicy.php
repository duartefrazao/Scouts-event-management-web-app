<?php


namespace App\Policies;

use App\User;
use App\RegistrationRequest;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RegistrationRequestPolicy
{
    use HandlesAuthorization;

    public function show(User $user)
    {
        return $user->email === "agrupa-admin@agrupa.com";
    }

    public function list(User $user)
    {
        // Any user can list its own cards
        return true;
    }

    public function create(User $user)
    {
        // Any user can create a new card
        return Auth::check();
    }

    public function delete(User $user, Event $event)
    {
        // Only a card owner can delete it
        return $event->organizers()->has($user->id)->exists();
    }
}
