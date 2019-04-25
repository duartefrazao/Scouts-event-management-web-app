<?php

namespace App\Policies;

use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $event_id)
    {
        return true;
        //can only say yes/no if he is responsible and was already invited
       // return $user->is_responsible && Event::find($event_id)->participants->contains($event_id);
    }
}
