<?php

namespace App\Http\Controllers;


use App\GuardianExchange;
use Illuminate\Http\Request;

class GuardianExchangeController extends Controller
{


    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('auth:admin', ['only' => ['delete']]);

    }

    /**
     * Creates a new location.
     *
     * @param int $event_id
     * @param Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {
        $exchange = new GuardianExchangeController();

        $exchange->authorize('create', $exchange);

        $exchange->minor = $request->input('minor');
        $exchange->new_guardian = $request->input('new_guardian');
        $exchange->state = $request->input('state');

        return $exchange;
    }

    /**
     * Updates the state of an individual location.
     *
     * @param int $id
     * @param Request request containing the new state
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $exchange = GuardianExchange::find($id);

        $exchange->authorize('update', $exchange);

        $exchange->state = $request->input('state');
        $exchange->save();

        return $exchange;
    }

    /**
     * Deletes an individual location.
     *
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $exchange = GuardianExchange::find($id);

        $this->authorize('delete', $exchange);
        $exchange->delete();

        return $exchange;
    }

}
