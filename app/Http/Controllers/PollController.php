<?php

namespace App\Http\Controllers;


use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Comment;

class PollController extends Controller
{

    /**
     * Creates a new poll.
     *
     * @param event_id the event of the poll
     * @param Request request containing the description
     * @return Poll
     */
    public function create(Request $request, $event_id)
    {
        $poll = new Poll();

        $this->authorize('create', $event_id);

        $poll->event = $event_id;
        $poll->begin_date = $request->input('begin_date');
        $poll->end_date = $request->input('end_date');

        return $poll;
    }

    /**
     * Deletes an individual event.
     *
     * @param int $id
     * @return Poll
     */
    public function delete(Request $request, $id)
    {
        $poll = Poll::find($id);

        $this->authorize('delete', $poll);
        $poll->delete();

        return $poll;
    }

    public function update(Request $request, $id)
    {

        $poll = Poll::find($id);

        $this->authorize('update', $poll);

        $poll->end_date = $request->input('end_date');
        $poll->save();

        return $poll;

    }

}
