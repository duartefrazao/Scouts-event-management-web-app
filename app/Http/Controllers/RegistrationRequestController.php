<?php

namespace App\Http\Controllers;


use App\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|confirmed',
            'birthdate' => 'required|date'
        ]);
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


    public function create(Request $request)
    {

        //$this->authorize('create', $reg_request);

        if($request['password'] != $request['password_confirmation']){
            return null;
        }

        $data= request()->all();


        $this->validator($data)->validate();


        RegistrationRequest::create([
            'name' => $data['name'],
            'birthdate' =>$data['birthdate'],
            'email' => $data['email'],
            'description' => $data['description'],
            'password' => bcrypt($data['password']),
        ]);

        session()->flash('message','O teu registo foi efetuado com sucesso, receberás um email com o resultado da revisão feita pelo administrador');

        return  redirect()->route('login');
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
