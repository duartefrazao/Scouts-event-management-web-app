<?php

namespace App\Http\Controllers;


use App\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegistrationRequestController extends Controller
{

    /**
     * Shows the RegistrationRequest for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $reg_request = RegistrationRequest::find($id);

        //$this->authorize('show', $reg_request);

        return view('pages.reg_request', ['reg_request' => $reg_request]);
    }

    /**
     * Shows all RegistrationRequest.
     *
     * @return Response
     */
    public function list()
    {
        if (!Auth::check()) return redirect()->route('login');

        //$this->authorize('list', RegistrationRequest::class);

        $reg_requests = RegistrationRequest::all();

        return view('pages.events', ['reg_requests' => $reg_requests]);
    }

    /**
     * Creates a new RegistrationRequest.
     *
     * @param  int  $reg_request_id
     * @param  Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {
        $reg_request = new RegistrationRequest();

        //$this->authorize('create', $reg_request);

        if($request['password'] != $request['password_confirmation']){
            return null;
        }

        $reg_request->name = $request->input('name');
        $reg_request->email = $request->input('email');
        $reg_request->password = $request->input('password');
        $reg_request->birthdate = $request->input('birthdate');
        $reg_request->state = $request->input('state');
        $reg_request->description = $request->input('description');

        $reg_request.save();

        return $reg_request;
    }

    /**
     * Updates the state of an individual RegistrationRequest.
     *
     * @param  int  $id
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $reg_request = RegistrationRequest::find($id);

        //$this->authorize('update', $reg_request);

        $reg_request->state = $request->input('state');
        $reg_request->save();

        return $reg_request;
    }

    /**
     * Deletes an individual RegistrationRequest.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $reg_request = RegistrationRequest::find($id);

        $this->authorize('delete', $reg_request);
        $reg_request->delete();

        return $reg_request;
    }

}
