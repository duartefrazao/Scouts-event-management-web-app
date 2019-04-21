<?php

namespace App\Http\Controllers;


use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    /**
     * Creates a new location.
     *
     * @param Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {
        $location = new Location();

        $location->authorize('create', $location);

        $location->name = $request->input('name');
        $location->coordinates = $request->input('coordinates');
        $location->postal_code = $request->input('postal_code');

        return $location;
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
        $location = Location::find($id);

        $location->authorize('update', $location);

        $location->name = $request->input('name');
        $location->save();

        return $location;
    }

    /**
     * Deletes an individual location.
     *
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $location = Location::find($id);

        $this->authorize('delete', $location);
        $location->delete();

        return $location;
    }

}
