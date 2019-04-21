<?php

namespace App\Http\Controllers;


use App\Poll;
use Illuminate\Http\Request;


use App\Option;

class VoteController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Creates a new vote for an option
     *
     * @param option_id the option for the vote
     * @param Request request containing the description
     * @return Vote
     */
    public function create(Request $request, $option_id)
    {
        $vote = new Vote();

        $this->authorize('create', $option_id);

        $vote->option = $option_id;
        $vote->voter = Auth::id();

        return $vote;
    }

    /**
     * Deletes an individual vote.
     *
     * @param int $id
     * @return Vote
     */
    public function delete(Request $request, $id)
    {
        $vote = Vote::find($id);

        $this->authorize('delete', $vote);
        $vote->delete();

        return $vote;
    }


}
