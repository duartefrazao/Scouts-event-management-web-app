<?php

namespace App\Http\Controllers;


use App\Poll;
use Illuminate\Http\Request;


use App\Option;

class OptionController extends Controller
{

    /**
     * Creates a new option for a poll.
     *
     * @param poll_id the poll of the option
     * @param Request request containing the description
     * @return Poll
     */
    public function create(Request $request, $poll_id)
    {
        $option = new Poll();

        $this->authorize('create', $poll_id);

        $option->poll = $poll_id;
        $option->date = $request->input('date');

        return $option;
    }

    /**
     * Deletes an individual option.
     *
     * @param int $id
     * @return Poll
     */
    public function delete(Request $request, $id)
    {
        $option = Option::find($id);

        $this->authorize('delete', $option);
        $option->delete();

        return $option;
    }

    public function update(Request $request, $id)
    {

        $option = Option::find($id);

        $this->authorize('update', $option);

        $option->date = $request->input('date');
        $option->save();

        return $option;

    }

}
