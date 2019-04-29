<?php

namespace App\Policies;

use App\User;
use App\Comment;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentPolicy
{

    use HandlesAuthorization;

    public function create(Comment $user, Event $event)
    {

        return true;
        
    }

    public function store(User $user,$event){
        return true;
    }

    public function delete(User $user, Comment $comment)
    {
        // Only a card owner can delete it
        return $user->id == $comment->user_id;
    }

    
}
