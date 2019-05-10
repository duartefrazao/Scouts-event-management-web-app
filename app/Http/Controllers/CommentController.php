<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Comment;
use App\Event;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

        //$this->authorize('delete', $comment);

        if (Auth::id() == $comment->participant) {
            $comment->delete();
            return response(json_encode($comment->id), 200);
        } else
            return response(json_encode("Não podes apagar este comentário!"), 403);

    }

    public function store(Event $event)
    {

        $this->authorize('comment', $event);

        $result = $event->addComment(request('text'));

        $comment = Comment::join('user', 'user.id', '=', 'comment.participant')->select('comment.*', 'user.name')->where('comment.id', '=', $result->id)->first();

        $comment->date = date("m-d-Y H:i", strtotime($comment->date));


        return response(json_encode($comment), 200);
    }


    public function getAllComments(Event $event)
    {
        $comments = Comment::join('user', 'user.id', '=', 'comment.participant')->select('comment.*', 'user.name')->where('comment.event', '=', $event->id)->orderBy('comment.id', 'DESC')->get();

        foreach ($comments as $comment)
            $comment->date = date("m-d-Y H:i", strtotime($comment->date));
        return response(json_encode($comments), 200);
    }

}
