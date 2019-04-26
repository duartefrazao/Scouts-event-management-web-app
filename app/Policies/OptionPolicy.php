<?php

namespace App\Policies;

use App\User;
use App\Poll;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OptionPolicy
{
    use HandlesAuthorization;


    public function create(User $user, $poll_id)
    {

        $poll = Poll::find($poll_id);

        $event = Event::find($poll->event);

        // The person that creates the option must be an organizer
        return Auth::check() && $event->organizers->contains($user->id);
    }

    public function delete(User $user, Poll $poll)
    {

        $event = Event::find($poll->event);

        //Any organizer can delete a option
        return $event->organizers->contains($user->id);
    }

    public function update(User $user, Poll $poll)
    {
        $event = Event::find($poll->event);

        //Any organizer can delete the poll
        return $event->organizers->contains($user->id);

    }
}
