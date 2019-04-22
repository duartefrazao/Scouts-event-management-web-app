<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Comment;

class CommentController extends Controller
{

    /**
     * Creates a new comment.
     *
     * @param event_id the event of the comment
     * @param Request request containing the description
     * @return Response
     */
    public function create(Request $request, $event_id)
    {
        $comment = new Comment();

        $this->authorize('create', $event_id);

        $comment->participant = Auth::id();
        $comment->event = $event_id;
        $comment->date = $request->input('date');
        $comment->text = $request->input('text');

        return $comment;
    }

    /**
     * Deletes an individual event.
     *
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $comment = Comment::find($id);

        $this->authorize('delete', $comment);
        $comment->delete();

        return $comment;
    }

}