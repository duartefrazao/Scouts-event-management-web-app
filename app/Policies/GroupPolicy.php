<?php

namespace App\Policies;

use App\Group;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class GroupPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Group $group)
    {
        return $group->members->contains($user->id) || $group->moderators->contains($user->id);
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

    public function delete(User $user, Group $group)
    {
        // Only a group moderator can delete the group
        return $group->moderators->contains($user->id);
    }
}
