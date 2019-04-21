<?php

namespace App\Policies;

use App\Option;
use App\Poll;
use App\User;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    public function create(User $user, $option_id)
    {

        $option = Option::find($option_id);

        $poll = Poll::find($option->poll);

        $event = Event::find($poll->event);

        // The person that creates the poll must be an organizer
        return $user->is_responsible && ($event->participants->contains($user->id) || $event->organizers->contains($user->id));
    }

    public function delete(User $user, Vote $vote)
    {

        //any person can delete her own votes
        return $user->id === $vote->voter;

    }

}
