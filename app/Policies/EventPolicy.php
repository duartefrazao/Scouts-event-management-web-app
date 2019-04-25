<?php

namespace App\Policies;

use App\User;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Event $event)
    {
        return $event->participants->contains($user->id) || $event->organizers->contains($user->id);
    }

    public function list(User $user)
    {
        // Any user can list its own cards
        return true;
    }

    public function create(User $user)
    {
        // Any user can create a new card
        return Auth::check() && $user->is_responsible;
    }

    public function delete(User $user, Event $event)
    {
        // Only a card owner can delete it
        return $event->organizers->contains($user->id);
    }
}
