<?php

namespace App\Policies;

use App\User;
use App\Comment;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $event_id)
    {
        // The person that creates the comment must belong to the event

        $event = Event::find($event_id);

        return Auth::check() && ($event->participants->contains($user->id) || $event->organizers->contains($user->id));
    }

    public function delete(User $user, Comment $comment)
    {
        // Only a card owner can delete it
        return $user->id == $comment->user_id;
    }
}
