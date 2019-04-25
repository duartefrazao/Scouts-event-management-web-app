<?php

namespace App\Policies;

use App\User;
use App\Comment;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PollPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $event_id)
    {

        $event = Event::find($event_id);

        // The person that creates the poll must be an organizer
        return Auth::check() && $event->organizers->contains($user->id);
    }

    public function delete(User $user, Poll $poll)
    {

        $event = Event::find($poll->event);

        //Any organizer can delete the poll
        return $event->organizers->contains($user->id);
    }

    public function update(User $user, Poll $poll)
    {
        $event = Event::find($poll->event);

        //Any organizer can delete the poll
        return $event->organizers->contains($user->id);

    }
}
